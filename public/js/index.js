$(document).ready(function () {
    $('.copy').click(function () {
        $(this).css('backgroundImage', 'url(../images/iscopy.png)').text('已复制');
    });

    $('.web-box-copybtn').click(function () {
        $(this).text('已复制');
    });

    var h = $(window).height();
    $("aside").height(h);
});


function decodeJson($id, $content) {
    var options = {
        dom: '#' + $id
    };
    var jf = new JsonFormater(options);
    jf.doFormat($content);
}