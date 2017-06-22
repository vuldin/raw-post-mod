# Raw post mod
Adds a new field (rawcontent) to the post response from Wordpress API that contains the post's raw content.

## Purpose
While making a site using React/Next/Mobx and other javascript libraries, I wanted to get posts from wordpress and then render them as components in the app.
The issue is that Wordpress by default only returned a rendered version of the post content when making an unauthenticated request.
The raw content is a little closer to what is needed for being able to get the type of data I need, but it is only one step in the right direction.

Here is an example of what an unauthenticated post GET request returns by default:
```json
{
  "id":19,
  "date":"2017-06-22T10:03:07",
  "date_gmt":"2017-06-22T17:03:07",
  "guid":{
    "rendered":"http:\/\/jlpwptest.localtunnel.me\/?p=19"
  },
  "modified":"2017-06-22T10:03:07",
  "modified_gmt":"2017-06-22T17:03:07",
  "slug":"title",
  "status":"publish",
  "type":"post",
  "link":"http:\/\/jlpwptest.localtunnel.me\/2017\/06\/22\/title\/",
  "title":{
    "rendered":"Title"
  },
  "content":{
    "rendered":"<p>First sentence of first paragraph. Second sentence of first paragraph.<\/p>\n<p>First sentence of second paragraph. Second sentence of second paragraph.<\/p>\n<p><img class=\"alignnone size-medium wp-image-20\" src=\"http:\/\/jlpwptest.localtunnel.me\/wp-content\/uploads\/2017\/06\/Test_card-300x169.png\" alt=\"\" width=\"300\" height=\"169\" srcset=\"http:\/\/jlpwptest.localtunnel.me\/wp-content\/uploads\/2017\/06\/Test_card-300x169.png 300w, http:\/\/jlpwptest.localtunnel.me\/wp-content\/uploads\/2017\/06\/Test_card.png 640w\" sizes=\"(max-width: 300px) 100vw, 300px\" \/><\/p>\n<p>First sentence of third paragraph. Second sentence of third paragraph.<\/p>\n",
    "protected":false
  },"excerpt":{
    "rendered":"<p>First sentence of first paragraph. Second sentence of first paragraph. First sentence of second paragraph. Second sentence of second paragraph. First sentence of third paragraph. Second sentence of third paragraph.<\/p>\n",
    "protected":false
  },
  "author":1,
  "featured_media":0,
  "comment_status":"open",
  "ping_status":"open",
  "sticky":false,
  "template":"",
  "format":"standard",
  "meta":[],
  "categories":[1],
  "tags":[],
  "_links":{
    "self":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/posts\/19"}],
    "collection":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/posts"}],
    "about":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/types\/post"}],
    "author":[{"embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/users\/1"}],
    "replies":[{"embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/comments?post=19"}],
    "version-history":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/posts\/19\/revisions"}],
    "wp:attachment":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/media?parent=19"}],
    "wp:term":[{"taxonomy":"category","embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/categories?post=19"},{"taxonomy":"post_tag","embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/tags?post=19"}],
    "curies":[{"name":"wp","href":"https:\/\/api.w.org\/{rel}","templated":true}]
  }
}
```
The `guid`, `title`, `content`, and `excerpt` only return a rendered version of that object's data.
For external webapps using the REST API this makes it difficult to determine for themselves how to best render this content.
This is especially the case with the `content` and `excerpt` objects.

Here is an example of the same request above after this plugin is installed:
```json
{
  "id":19,
  "date":"2017-06-22T10:03:07",
  "date_gmt":"2017-06-22T17:03:07",
  "guid":{
    "rendered":"http:\/\/jlpwptest.localtunnel.me\/?p=19"
  },
  "modified":"2017-06-22T10:03:07",
  "modified_gmt":"2017-06-22T17:03:07",
  "slug":"title",
  "status":"publish",
  "type":"post",
  "link":"http:\/\/jlpwptest.localtunnel.me\/2017\/06\/22\/title\/",
  "title":{
    "rendered":"Title"
  },
  "content":{
    "rendered":"<p>First sentence of first paragraph. Second sentence of first paragraph.<\/p>\n<p>First sentence of second paragraph. Second sentence of second paragraph.<\/p>\n<p><img class=\"alignnone size-medium wp-image-20\" src=\"http:\/\/jlpwptest.localtunnel.me\/wp-content\/uploads\/2017\/06\/Test_card-300x169.png\" alt=\"\" width=\"300\" height=\"169\" srcset=\"http:\/\/jlpwptest.localtunnel.me\/wp-content\/uploads\/2017\/06\/Test_card-300x169.png 300w, http:\/\/jlpwptest.localtunnel.me\/wp-content\/uploads\/2017\/06\/Test_card.png 640w\" sizes=\"(max-width: 300px) 100vw, 300px\" \/><\/p>\n<p>First sentence of third paragraph. Second sentence of third paragraph.<\/p>\n",
    "protected":false
  },"excerpt":{
    "rendered":"<p>First sentence of first paragraph. Second sentence of first paragraph. First sentence of second paragraph. Second sentence of second paragraph. First sentence of third paragraph. Second sentence of third paragraph.<\/p>\n",
    "protected":false
  },
  "author":1,
  "featured_media":0,
  "comment_status":"open",
  "ping_status":"open",
  "sticky":false,
  "template":"",
  "format":"standard",
  "meta":[],
  "categories":[1],
  "tags":[],
  "rawcontent": "First sentence of first paragraph. Second sentence of first paragraph. First sentence of second paragraph. Second sentence of second paragraph. <img class="alignnone size-medium wp-image-20" src="http://jlpwptest.localtunnel.me/wp-content/uploads/2017/06/Test_card-300x169.png" alt="" width="300" height="169" /> First sentence of third paragraph. Second sentence of third paragraph.",
  "_links":{
    "self":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/posts\/19"}],
    "collection":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/posts"}],
    "about":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/types\/post"}],
    "author":[{"embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/users\/1"}],
    "replies":[{"embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/comments?post=19"}],
    "version-history":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/posts\/19\/revisions"}],
    "wp:attachment":[{"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/media?parent=19"}],
    "wp:term":[{"taxonomy":"category","embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/categories?post=19"},{"taxonomy":"post_tag","embeddable":true,"href":"http:\/\/jlpwptest.localtunnel.me\/wp-json\/wp\/v2\/tags?post=19"}],
    "curies":[{"name":"wp","href":"https:\/\/api.w.org\/{rel}","templated":true}]
  }
}
```

The raw content is better than the rendered content, but it still has issues.
The main issue is that it doesn't give any indication where paragraphs start and end.
I'll be looking into how this plugin can modify the raw content so that it is in a JSON format. The response could be something like the following:
```json
{
  ...
  "rawmod": [
    "First sentence of first paragraph. Second sentence of first paragraph.",
    "First sentence of second paragraph. Second sentence of second paragraph.",
    "http://jlpwptest.localtunnel.me/wp-content/uploads/2017/06/Test_card-300x169.png",
    "First sentence of third paragraph. Second sentence of third paragraph."
  ],
  ...
}
```

In this array format each entry would be considered a new paragraph.
By default a non-URL string would be considered paragraph text, and a URL would be considered an image.
This could be expanded so that objects would be returned that gave details as to what type of block the content should be.
For example:
```json
{
  ...
  "rawmod": [
    {
      type: "text",
      value: "First sentence of first paragraph. Second sentence of first paragraph."
    }
    {
      type: "image",
      value: "http://jlpwptest.localtunnel.me/wp-content/uploads/2017/06/Test_card-300x169.png"
    }
  ],
  ...
}
```
