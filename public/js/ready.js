new navScroll({
    nav: {
        id: 'navigation0',
        current: 'current',
        speed: 25,
        fixPx: 0
    }
});

$(function () {
    $(".button").click(function () {
        var url = $(this).parent().find("input.api_url").val();
        if (haveFile(this)) {
            fileFormSubmit(this, url);
        } else {
            ajaxJson(this, url);
        }
    });

    function haveFile($this) {
        var files = $($this).parent().find("input[type='file']");
        return (files["length"] > 0) && (files.val() != "");
    }

    function fileFormSubmit($this, $url) {
        $($this).parent().ajaxSubmit({
            url: $url,
            type: 'POST',
            dataType: 'json',
            contentType: 'multipart/form-data',
            headers: JSON.parse(getParamsJsonData($this, "headers")),
            success: function (data) {
                showReturn($this, data);
            },
            error: function (data) {
                alert(JSON.stringify(data) + "--上传失败,请刷新后重试");
            }
        });
    }

    function ajaxJson($this, $url) {
        var method = $($this).parent().find("input.api_url").attr("title");
        if (method == "GET" || method == "DELETE") {
            var data = null;
        } else {
            var data = getParamsJsonData($this, "params");
        }
        $.ajax({
            method: method,
            url: $url,
            data: data,
            headers: JSON.parse(getParamsJsonData($this, "headers")),
            contentType: 'json',
            success: function (data) {
                showReturn($this, data);
            }
        });
    }

    function getParamsJsonData($this, $type) {
        var data = {};
        var self = $($this).parent().find("." + $type);
        var values = $($this).parent().find("." + $type + "_val");
        var type = $($this).parent().find("." + $type + "_type");
        var size = self.size();
        for (var i = 0; i < size; i++) {
            if (self.eq(i).is(":checked")) {
                data[self.eq(i).val()] = (type.eq(i).html() == "int") ? Number(values.eq(i).val()) : values.eq(i).val();
            }
        }

        return JSON.stringify(data);
    }

    function showReturn($this, $data) {
        var id = "return_" + $($this).attr("name");
        var title = $($this).parent().siblings(".send-title");
        var response = $($this).parent().siblings(".response-content");

        title.show(1000);
        response.hide().show(1000);
        decodeJson(id, $data, $(".aside-head span").eq(0).attr("title"));
    }
});

var clipboard = new Clipboard('.copy_content');
clipboard.on('success', function (e) {
    console.log("Successfully Copy!");
});

clipboard.on('error', function (e) {
    alert("请使用升级或更换浏览器！");
});