function checkMinimumStay(starts_at)
{
    var minimumStayObject = new Object;
    minimumStayObject.starts_at = starts_at;
    $.ajax({
        url: base_url+'/api/minimum-stay',
        type: 'GET',
        data: minimumStayObject,
        success: function(data) {
            if (typeof updatesEndsAt !== "undefined") {
                updatesEndsAt(data)
            } else {
                return data
            }

        }
    });
}
