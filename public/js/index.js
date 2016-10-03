$(document).ready(function () {
    $(".copy-text").bind('copy', function () {
        var index = $(".copy-text").index(this);
        $('.copy').eq(index).css('backgroundImage', 'url(./images/iscopy.png)');
        $('.copy').eq(index).text('已复制');
    });
    $(".web-box-copybtn").click(function () {
        var index = $(".web-box-copybtn").index(this);
    })
    var h = $(window).height()
    $("aside").height(h)
});

function decodeJson($id, $content) {
    var options = {
        dom: '#' + $id
    };
    var jf = new JsonFormater(options);
    jf.doFormat($content);
}
