
function getPostsListPromise(newest=false, offset=0, authorId=false) {
    let querystring = "/api/posts"+(location.search?location.search+"&":"?")+"offset="+offset;
    if (authorId)
    {
        querystring += "&authorId="+authorId;
    }
    if (newest)
    {
        querystring += "&newest=";
    }

    return axios.get(querystring).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
        });
}

function getAuthorsListPromise(offset=0) {
    let querystring = "/api/authors"+(location.search?location.search+"&":"?")+"offset="+offset;

    return axios.get(querystring).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
        });
}

function getPostSetRatePromise(postId, likeStatus) {
    let querystring = "/api/posts/"+postId+"/"+(likeStatus?"like":"dislike");

    return axios.post(querystring,{}).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
        });
}

function getPostGetRatePromise(postId) {
    let querystring = "/api/posts/"+postId+"/rating";
    return axios.get(querystring).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
        });
}

function getCommentsListPromise(postId, offset=0) {
    let querystring = "/api/posts/"+postId+"/comments"+(location.search?location.search+"&":"?")+"offset="+offset;
    return axios.get(querystring).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
        });
}

function getPostPromise(postId) {
    let querystring = "/api/posts/"+postId;

    return axios.get(querystring).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
    });
}

function getAuthorPromise(authorId) {
    let querystring = "/api/authors/"+authorId;

    return axios.get(querystring).then(result=>result.data).catch(
        reason=>{console.log(reason.response.data??reason.responseText);
        });
}

export {getPostsListPromise, getCommentsListPromise, getPostPromise, getPostSetRatePromise, getPostGetRatePromise,
    getAuthorsListPromise, getAuthorPromise}
