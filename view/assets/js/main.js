$(document).ready(function() {
    $("#new").hide();
    $(".csvForm").submit(function(e) {
        e.preventDefault();
        if ($('#myTable').length>=1) {
            $('#myTable').dataTable().fnDestroy();
        }
        $("#ajaxContent").fadeOut(300)
        var formData = new FormData(), fileField = $("#csvFile"), inputFile = fileField[0].files[0], tokenVal = $("#token").val();
        formData.append('upload', inputFile)
        formData.append('format', 1)
        formData.append('token', tokenVal)
        swal({
          html: 'Your file is being uploaded please wait.',
          timer: 1800,
          onOpen: () => {
            swal.showLoading()
          }
        })
        setTimeout(function() {
            $.ajax({
                url: myUrl+"view/readCSV.php",
                type: "post",
                processData: false,
                contentType: false,
                data: formData,
                success: function(msg) {
                    try {
                       jsonResult = JSON.parse(msg);
                       console.log(jsonResult.success);
                       if (jsonResult.success==false) {
                            swal({
                              type: 'error',
                              title: 'Atention',
                              html: jsonResult.body,
                              timer: 18500
                            })
                       } else {
                           $("#ajaxContent").html(jsonResult.body);
                            var fileName = "Exported CSV";
                            var pageCheck = $("#myTable tr > th").length;
                            var pageSize = "A4";
                            if (pageCheck>10) {
                                pageSize = "Legal"
                            }
                            if (pageCheck>=12) {
                                pageSize = "Tabloid"
                            }
                            $('#myTable').DataTable({
                                dom: '<"top"Bflp<"clear">>rt<"bottom"Bifp<"clear">>',
                                buttons: [
                                    {
                                        extend: 'copy',
                                    },
                                    {
                                        extend: 'print',
                                    },
                                    {
                                        extend: 'excelHtml5',
                                        title: fileName
                                    },
                                    {
                                        extend: 'pdfHtml5',
                                        title: fileName,
                                        orientation : 'landscape',
                                        pageSize : pageSize,
                                        text : '<i class="fa fa-file-pdf-o"> PDF</i>',
                                        titleAttr : 'PDF'
                                    }
                                ],
                                "pageLength": 100
                            });
                            swal({
                              type: 'success',
                              title: 'File Uploaded',
                              html: "Click on any column to order the elements as needed, if you want to look for specific values please use the search box :).",
                              timer: 15500
                            })            
                            $("#ajaxContent").fadeIn(300);
                            $(".csvForm").fadeOut();
                            $("#new").fadeIn();
                       }
                    }
                    catch (e) {
                        console.log(e);
                    };
                },
                error: function(exr) {
                    console.log(exr);
                }
            });
        },2000);
        $(this).trigger("reset");
    });
    $("#new").click(function() {
        $(".csvForm").fadeIn();
        $(this).fadeOut();
    });
});