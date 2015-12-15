function getJson(url, data) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        global: false,
        async: false,
        data: data,
        success: function (json) {
            return json;
        },
        error: function (error) {
            return error;
        }
    }).responseText);
}

