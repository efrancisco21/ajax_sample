<?php
include("db.php");

//get data
if (isset($_POST['id'])) {
$id = mysqli_real_escape_string($connection, $_POST['id']);
$query = "SELECT * FROM cars WHERE car_id = {$id}";
$query_car_info = mysqli_query($connection, $query);

if(!$query_car_info) {
    die('Query failed' . mysqli_error($connection));
}

while ($row = mysqli_fetch_array($query_car_info)) {
   echo "<input rel='".$row['car_id']."' type='text' class='form-control car_input' value='".$row['car_name']."'><br>";
   echo "<input type='button' class='btn btn-success update' value='Update'>&nbsp";
   echo "<input type='button' class='btn btn-danger delete' value='Delete'>&nbsp";
   echo "<button type='button' class='btn btn-link close_container'>
   <i class='fas fa-times'></i>
 </button>&nbsp";

}

}

//update data
if(isset($_POST['updatethis'])) {
   $id = mysqli_real_escape_string($connection, $_POST['car_id']);
   $car_name = mysqli_real_escape_string($connection, $_POST['car_name']);

   $query = "UPDATE cars SET car_name = '{$car_name}' WHERE car_id = {$id}";

   $result_set = mysqli_query($connection, $query);

   if(!$result_set) {
       die('QUERY FAILED' . mysqli_error($connection));
   }

}

//delete data
if(isset($_POST['deletethis'])) {
    $id = mysqli_real_escape_string($connection, $_POST['car_id']);
 
    $query = "DELETE FROM cars WHERE car_id = {$id}";
 
    $result_set = mysqli_query($connection, $query);
 
    if(!$result_set) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
 
 }

?>

<script>
    $(document).ready(function() { 
        let car_id;
        let car_name;
        let updatethis = 'update';
        let deletethis = 'delete';

         $('.car_input').on('input', function() {
            car_id = $(this).attr('rel');
            car_name = $(this).val();

        //     alert(title);
         });

        $('.update').on('click', function() {
            $.post("process.php", {
                car_id: car_id,
                car_name: car_name, 
                updatethis: updatethis,
            }, function(data) {
                //alert(data);
                $('#feedback').text('Record updated');
            });
        });

        $('.delete').on('click', function() {
            if(confirm('Are you sure you want to delete?')) {
            car_id = $('.car_input').attr('rel');
            $.post("process.php", {
                car_id: car_id, 
                deletethis: deletethis,
            }, function(data) {
                //alert(data);
                $('#feedback').text('Record deleted');
                setTimeout(function () {
                    $('#feedback').text("");
                    $('#action-container').hide();
                 }, 2000);
               
            });
            }
        });

        $('.close_container').on('click', function() {
                $('#feedback').text("");
                $('#action-container').hide();
        });

    });
</script>