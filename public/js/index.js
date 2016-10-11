changeMenu(0);
$(document).ready(function () {
    $('.copy').click(function () {
        $(this).css('backgroundImage', 'url(' + $(".aside-head span").eq(0).attr("title") + '/images/iscopy.png)').text('已复制');
    });

    $('.web-box-copybtn').click(function () {
        $(this).text('已复制');
    });

    $("input.api_url").focus(function () {
        $(this).siblings(".copy").hide(500);
    });

    $("input.api_url").blur(function () {
        $(this).siblings(".copy").show(500);
    });

    $(".file_input").click(function () {
        $(this).siblings("input[type='file']").click();
    });

    $("input[type='file']").change(function () {
        $(this).siblings(".file_input").val(this.files[0].name);
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