import {hidePreloader} from "@/commonLogic";
import {getAuthorsListPromise, getAuthorPromise} from "@/apiLogic";

function loadAuthorsListData() {
    let offset = $(".row.authors").length;

    fillAuthorsListData(getAuthorsListPromise(offset));
}

function fillAuthorsListData(dataPromise)
{
    dataPromise.then((result)=>{
        let curCount = $(".row.authors").length;
        result.data.forEach(function (elem, key) {
            let avatarField = "<img class='avatar' src='"+elem.iconPath+"' alt='Аватар автора'>";

            let curIndex = curCount + key;
            let newElement = renderAuthorElement(elem, curIndex, avatarField);

            $(newElement).insertBefore($(".moreAuthors"));
        });

        showHideGetMoreAuthorsButton(result.meta.to<result.meta.total)

        hidePreloader();
    })
}

function renderAuthorElement(elem) {
    return "<div class='row authors flex'>\n" +
        "                <div class='w-2/12'>\n" +
        "                    <img class='avatar pt-1' src='" + elem.iconPath + "' alt='Аватар автора'>\n" +
        "                </div>\n" +
        "                <div class='w-9/12'>\n" +
        "                   <div class='card flex flex-col px-6'>\n" +
        "                       <div class='card-title'>\n" +
        "                           <div class='row flex'>\n" +
        "                               <div class='w-8/12 font-bold'>" + elem.username + "</div>\n" +
        "                               <div class='w-4/12'>Дата регистрации: " + elem.created_at + "</div>\n" +
        "                           </div>\n" +
        "                       </div>\n" +
        "                       <div class='card-body grow'>\n" +
        "                           <p> " + elem.description + "</p>\n" +
        "                       </div>\n" +
        "                       <div class='card-bottom'><p> Количество постов автора: " + elem.posts_count +
        "                           <a class='font-bold' href='/authors/" + elem.id + "/posts'>Перейти</a></p>\n" +
        "                       </div>\n" +
        "                   </div>\n" +
        "                </div>\n" +
        "            </div>";
}

function loadAuthorInfo(authorId) {
    fillAuthorData(getAuthorPromise(authorId));
}

function fillAuthorData(dataPromise)
{
    dataPromise.then((result)=>{
        let avatarField = "<img class='avatar' src='"+result.data.iconPath+"' alt='Аватар автора'>";
        let newElement = renderAuthorElement(result.data, 0, avatarField);
        $(".row.authors").replaceWith($(newElement));
    })
}

function showHideGetMoreAuthorsButton(show=true)
{
    if (show)
        $(".morePosts").show();
    else
        $(".morePosts").hide();
}

export {loadAuthorsListData, loadAuthorInfo}
