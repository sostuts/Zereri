changeMenu(0);
$(document).ready(function () {
    $('.copy').click(function () {
        $(this).css('backgroundImage', 'url(' + $(".aside-head span").eq(0).attr("title") + '/images/iscopy.png)').text('已复制');
    });

    $('.web-box-copybtn').click(function () {
        $(this).text('已复制');
    });

    var h = $(window).height();
    $("aside").height(h);

    $("#select").change(function () {
        var index = $(this).children('option:selected').val();

        changeMenu(index);
        new navScroll({
            nav: {
                id: "navigation" + index,
                current: "current",
                speed: 25,
                fixPx: 0
            }
        });
    });
});

function changeMenu($index) {
    $(".list").hide().eq($index).show(1000);
    $(".edition").hide().eq($index).show(1000);
}

function decodeJson($id, $content, $path) {
    var options = {
        dom: '#' + $id
    };
    var jf = new JsonFormater(options, $path);
    jf.doFormat($content);
}