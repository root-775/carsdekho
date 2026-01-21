$(document).ready(function () {
    $('#bannerTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true
    });


    $(document).ready(function () {
        $('#carsTable').DataTable({
            pageLength: 10,
            ordering: true
        });
    });
});