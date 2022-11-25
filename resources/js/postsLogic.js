import {bbCodeDecode, scrollIntoViewIfNeeded, checkNewestPostsFlag, hidePreloader} from "@/commonLogic";
import {getPostsListPromise, getPostSetRatePromise, getPostGetRatePromise, getPostPromise, getCommentsListPromise} from "./apiLogic"

function loadPostsData(scrollDown=true) {
    let offset = $(".row.post").length;
    let newest = checkNewestPostsFlag();

    fillPostsListData(getPostsListPromise(newest, offset));

    if (scrollDown){
        let scrollToElement = $(".row.post:last");
        scrollIntoViewIfNeeded(scrollToElement);
    }
}

function loadAuthorsPostsData(authorId) {
    let offset = $(".row.post").length;
    let promise = getPostsListPromise(false, offset, authorId);
    fillPostsListData(promise, authorId);
}

function fillPostsListData(dataPromise, authorId=null)
{
    dataPromise.then((result)=>{
        let curCount = $(".row.post").length;
        result.data.forEach(function (elem, key) {
            let avatarField = '';
            if (!authorId)
                avatarField = "<img class='avatar' src='"+elem.iconPath+"' alt='Аватар автора'>";

            let curIndex = curCount + key;
            let newElement = renderPostElement(elem, curIndex, avatarField);

            $(newElement).insertBefore($(".morePosts"));
        });

        showHideGetMorePostsButton(result.meta.to<result.meta.total)

        hidePreloader();

        hidePostsExpandButton();
    })
}

function renderPostElement(elem,curIndex, avatarField="") {
    return "<div class='row post flex'>\n" +
        "                <input type='hidden' class='postId' value='" + elem.id + "'>\n" +
        "                <div class='w-2/12 flex flex-col items-stretch pt-2'>\n" +
        "                    <div class='grow-0 self-start'>Автор: <a class='font-bold' href='/authors/" + elem.author_id + "/posts'>" + elem.authorName + "</a>" + "</div>\n" +
        "                    <div class='grow self-start pt-1'>" + avatarField + "</div>\n" +
        "                    <div>Дата публикации: \n" + elem.created_at + "</div>\n" +
        "                </div>\n" +
        "                <div class='w-9/12'>\n" +
        "                   <div class='card px-6'>\n" +
        "                       <div class='card-title'>\n" +
        "                           <div class='flex flex-row'>\n" +
        "                               <div class='w-9/12 font-bold'>" + elem.title + "</div>\n" +
        "                               <div class='w-3/12 flex flex-row items-center'> Рейтинг: <img alt='like' class='rating-arrow rating-down' src='/storage/down-arrow-red.svg'><span class='rating-count'>" + elem.likes_count + "</span><img alt='dislike' class='rating-arrow rating-up' src='/storage/up-arrow-green.svg'></div>\n" +
        "                           </div>\n" +
        "                       </div>\n" +
        "                       <input type='checkbox' data-more-checker='card-read-more-checker' id='card-read-more-checker-" + curIndex + "'/>\n" +
        "                       <div class='card-body text-justify'>\n" +
        "                           <p>" + bbCodeDecode(elem.body) + "</p>\n" +
        "                           <div class='card-bottom'>\n" +
        "                           </div>\n" +
        "                       </div>\n" +
        "                       <a class='font-bold' href='/posts/" + elem.id + "/comments/'>" + elem.comments_count_text + "</a>\n" +
        "                       <label for='card-read-more-checker-" + curIndex + "' class='card-read-more-button'></label>\n" +
        "                   </div>\n" +
        "                </div>\n" +
        "            </div>";
}

function hidePostsExpandButton()
{
    $.each($(".row.post"),function (index,elem) {
        if ($(elem).find('.card-body').height()<parseInt($(elem).find('.card-body').css('max-height')))
        {
            $(elem).find('.card-read-more-button').remove();
        }
    });
}

function loadCommentsData(postId) {
    let offset = $(".row.comment").length;

    fillCommentsListData(getCommentsListPromise(postId, offset));
}

function fillCommentsListData(dataPromise){

    dataPromise.then(
        result => {
            let curCount = $(".row.comment").length;

            result.data.forEach(function (elem, key) {
                let curIndex = ++curCount;
                let newElement = "<div class='row comment flex'>\n" +
                    "                <div class='w-2/12 flex flex-col items-stretch'>\n" +
                    "                    <div class='grow-0 self-start'>№" + curIndex + "    Автор: <a href='/authors/" + elem.authorId + "/posts'>" + elem.authorName + "</a></div>" +
                    "                    <div class='grow self-start pt-1'><img class='avatar' src='" + elem.iconPath + "' alt='Аватар автора'></div>" +
                    "                    <div>Дата комментария: \n" + elem.created_at + "</div>\n" +
                    "                </div>\n" +
                    "                <div class='w-9/12'>\n" +
                    "                   <div class='card px-6'>\n" +
                    "                       <input type='checkbox' checked data-more-checker='card-read-more-checker' id='card-read-more-checker-" + curIndex + "'/>\n" +
                    "                       <div class='card-body text-justify'>\n" +
                    "                           <p>" + bbCodeDecode(elem.body) + "</p>\n" +
                    "                           <div class='card-bottom'>\n" +
                    "                           </div>\n" +
                    "                       </div>\n" +
                    "                   </div>\n" +
                    "                </div>\n" +
                    "            </div>";

                $(newElement).insertBefore($(".moreComments"));
            });

            if (curCount > 0) {
                $(".hasComments").show();
            }

            showHideGetMoreCommentsButton(result.meta.to<result.meta.total);
            hidePreloader();
        }
    )
}

function loadPostInfo(postId) {
    fillPostData(getPostPromise(postId));
}

function fillPostData(dataPromise)
{
    dataPromise.then((result)=>{
        let avatarField = "<img class='avatar' src='"+result.data.iconPath+"' alt='Аватар автора'>";
        let newElement = renderPostElement(result.data, 0, avatarField);
        $(".row.post").replaceWith($(newElement));
    })
}

function showHideGetMorePostsButton(show=true)
{
    if (show)
        $(".morePosts").show();
    else
        $(".morePosts").hide();
}

function showHideGetMoreCommentsButton(show=true)
{
    if (show)
        $(".moreComments").show();
    else
        $(".moreComments").hide();
}

function ratePost(postId, likeStatus, ratingField){
    getPostSetRatePromise(postId, likeStatus)
        .then(()=>{
            getPostGetRatePromise(postId).then(result=>{
                ratingField.html(result);
            })
        });

}

export {loadPostsData, loadAuthorsPostsData, loadCommentsData, loadPostInfo, ratePost}
