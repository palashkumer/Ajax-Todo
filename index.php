<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ajax Crud</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container">
        <h1 class="text-primary text-center"> Students List</h1>
        <div class="d-flex justify-content-end btnDiv">
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add Student</button>
        </div>
        <div>
            <div id="students-content"> </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Students</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Name : </label>
                            <input type="text" name="" id="name" placeholder="enter name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label> Email : </label>
                            <input type="email" name="" id="email" placeholder="enter email " class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Phone : </label>
                            <input type="text" name="" id="phone" placeholder="enter phone number " class="form-control" required>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addStudentRecord()">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        <!-- Update Modal -->
        <div id="update_user_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Students</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update_name"> Name : </label>
                            <input type="text" name="" id="update_name" placeholder="enter name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="update_email"> Email : </label>
                            <input type="email" name="" id="update_email" placeholder="enter email " class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="update_phone"> Phone : </label>
                            <input type="text" name="" id="update_phone" placeholder="enter phone number " class="form-control" required>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateUserDetails()">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <input type="hidden" name="" id="hidden_user_id">
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                readStudentRecords();
            });

            function readStudentRecords() {
                var readStudentRecord = "readStudentRecord";

                $.ajax({
                    url: "Backend.php",
                    type: "POST",
                    data: {
                        readStudentRecord: readStudentRecord
                    },
                    success: function(data, status) {
                        $("#students-content").html(data);
                    }

                });
            }


            function addStudentRecord() {
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();

                $.ajax({
                    url: "Backend.php",
                    type: "POST",
                    data: {
                        name: name,
                        email: email,
                        phone: phone
                    },
                    success: function(data, status) {
                        readStudentRecords();

                    }
                })
            }


            // Delete student records

            function deleteStudentRecord(deleteid) {
                var conf = confirm("Are you sure you want to delete ?");
                if (conf == true) {
                    $.ajax({
                        url: "Backend.php",
                        type: "POST",
                        data: {
                            deleteid: deleteid
                        },
                        success: function(data, status) {
                            readStudentRecords();
                        }
                    });
                }

            }

            // Get student records for update
            function GetStudentRecord(id) {
                $('#hidden_user_id').val(id);

                $.post('Backend.php', {
                    id: id
                }, function(data, status) {
                    var user = JSON.parse(data);
                    $('#update_name').val(user.name);
                    $('#update_email').val(user.email);
                    $('#update_phone').val(user.phone);
                });

                $('#update_user_modal').modal("show");
            }

            function updateUserDetails() {
                var update_name = $('#update_name').val();
                var update_email = $('#update_email').val();
                var update_phone = $('#update_phone').val();

                var update_hidden_user_id = $('#hidden_user_id').val();

                $.post('Backend.php', {
                    update_hidden_user_id: update_hidden_user_id,
                    update_name: update_name,
                    update_email: update_email,
                    update_phone: update_phone,
                }, function(data, status) {
                    $('#update_user_modal').modal('hide');
                    readStudentRecords();

                });
            }
        </script>

</body>

</html