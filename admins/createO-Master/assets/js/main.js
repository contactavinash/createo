var $container;

function postsocial(id, message, image, viasource, link) {
    console.log(message);
    console.log(image);
    console.log(viasource);
    console.log(link);
    if (viasource == "facebook") {

        window.location.href = newbase_url + "index.php/hauth/postfb?id=" + id + "&message=" + message + "&image=" + image + "&link=" + link;

    } else if (viasource == "twitter") {
        window.location.href = newbase_url + "index.php/hauth/posttweet?id=" + id + "&message=" + message + "&image=" + image;

    }
}

function generatemasonry(url, base_url, source) {
    $(document).ready(function () {


        newbase_url = base_url;
        $container = $('.masonryposts');

        $container.masonry({
            columnWidth: 280,
            itemSelector: '.item'
        });
        var pageno = 1;
        var orderby = "";
        var orderorder = "";
        var maxrow = 20;

        function fillchintandata() {

            $.getJSON(url, {
                search: "",
                pageno: pageno,
                orderby: orderby,
                orderorder: orderorder,
                maxrow: maxrow
            }, function (data) {

                console.log(data);
                createitems(data.queryresult);

            });
        };

        function createitems(data) {

            for (var i = 0; i < data.length; i++) {
                var linktext = "";
                if (data[i].link && data[i].link != "") {
                    linktext = "<div>Link: <a href='" + data[i].link + "' target='_new'>" + data[i].link + "</a></div>";
                }
                var pubbutton = "";
                if (source == "twitter") {
                    pubbutton = '<i class="fa fa-twitter"></i>&nbsp;Tweet Now</a>';
                } else {
                    pubbutton = '<i class="fa fa-facebook"></i>&nbsp;Post Now</a>';
                }

                if (data[i].image != "") {
                    var str = "<div class='item'><div class='image'><img class='img-responsive' src='" + base_url + "uploads/" + data[i].image + "'></div><div class='text'>" + data[i].text + linktext + "</div><div class='buttons text-center'><a href='#' class='btn btn-primary'  onclick=\"postsocial('" + data[i].id + "','" + data[i].text + "','" + base_url + "uploads/" + data[i].image + "','" + source + "','" + data[i].link + "')\">" + pubbutton + "</a></div></div>";
                    $container.append(str);
                    var $myimg = $(".item:last");
                    $(".item:last img").load(function () {
                        //                        $container.masonry('appended', $myimg).fadeIn();
                        $container.masonry('reload');
                        //$container.masonry('layout');
                    });
                    $(".item").ready(function () {
                        $container.masonry('appended', $myimg).fadeIn();
                        //                        $container.masonry('reload');
                        //$container.masonry('layout');
                    });
                } else {
                    var str = "<div class='item'><div class='text'>" + data[i].text + linktext + "</div><div class='buttons text-center'><a href='#' class='btn btn-primary' onclick=\"postsocial('" + data[i].id + "','" + data[i].text + "','','" + source + "','" + data[i].link + "')\">" + pubbutton + "</a></div></div>";
                    $container.append(str);
                    var $myimg = $(".item:last");
                    $container.masonry('appended', $myimg).fadeIn();
                }

            }

        };
        fillchintandata();
    });
}