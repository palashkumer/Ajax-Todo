<?php
$conn = mysqli_connect("localhost", "root", "", "ajaxcrud");
extract($_POST);

if (isset($_POST['readStudentRecord'])) {
    $data = '<table class="table table-bordered table-striped">
    <tr>
        <th> No.</th>
        <th> Name</th>
        <th> Email Address</th>
        <th> Phone Number</th>
        <th>Action</th>
    </tr>';

    $displayquery = "SELECT * FROM `students`";
    $result = mysqli_query($conn, $displayquery);

    if (mysqli_num_rows($result) > 0) {

        $number = 1;
        while ($row = mysqli_fetch_array($result)) {

            $data .= '<tr>
                <td>' . $number . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['phone'] . '</td>
                <td>
                    <button onclick="GetStudentRecord(' . $row['id'] . ')" class="btn btn-warning">Edit</button>
                    <button onclick="deleteStudentRecord(' . $row['id'] . ')" class="btn btn-danger">Delete</button>
                </td>
            </tr>';
            $number++;
        }
    }
    $data .= '</table>';
    echo $data;
}

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {

    $query = "INSERT INTO `students`(`name`, `email`, `phone`) VALUES ('$name','$email','$phone')";
    mysqli_query($conn, $query);
}


// delete Student records

if (isset($_POST['deleteid'])) {
    $userid = $_POST['deleteid'];
    $deletequery = "DELETE FROM students where id = '$userid' ";
    mysqli_query($conn, $deletequery);
}


// Get user id for update

if (isset($_POST['id']) && isset($_POST['id']) != "") {
    $user_id = $_POST['id'];

    $query = "SELECT * FROM students WHERE id = '$user_id'";
    if (!$result = mysqli_query($conn, $query)) {
        exit(mysqli_error($conn));
    }
    $response = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    } else {
        $response['status'] = 200;
        $response['message'] = 'Data not found';
    }

    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = 'Invalid Request';
}


// Update table
if (isset($_POST['update_hidden_user_id'])) {
    $update_hidden_user_id = $_POST['update_hidden_user_id'];
    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];
    $update_phone = $_POST['update_phone'];

    $query = " UPDATE `students` SET `name`=' $update_name',`email`=' $update_email',`phone`=' $update_phone' WHERE id ='$update_hidden_user_id'";
    mysqli_query($conn, $query);
}
