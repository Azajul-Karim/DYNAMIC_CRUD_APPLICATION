<?php
require './lib/session.php';
require_once 'inc/header.php';
require_once 'lib/dataBase.php';
?>

<?php
Session::init();
$msg = Session::get('msg');
if (!empty($msg)) {
  echo "<h2 style='color:green;text-align:center;'>  $msg  </h2>";
  session_unset();
}
?>
<div>
  <div>
    <h2 class="data"><strong>Student Data</strong>
      <?php include 'inc/space.php' ?>
      <a class=" button add-btn" href="lib/addstudent.php">
        Add Student
      </a>
    </h2>
  </div>
  <table>
    <tr>
      <th>Srial</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Action</th>
    </tr>
    <?php
    $db = new Database();
    $table = "tbl_student";
    $order_by = array('order_by' => 'id DESC');
    $studentData = $db->select($table, $order_by);

    if (!empty($studentData)) {
      $i = 0;
      foreach ($studentData as $data) {
        $i++ ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $data['name']; ?></td>
          <td><?php echo $data['email']; ?></< /td>
          <td><?php echo $data['phone']; ?></< /td>
          <td>
            <a class="button" href="./lib/editstudent.php?id=<?php echo $data['id'] ?>">Edit</a>&nbsp;
            <a class="button dlt-btn" href="./lib/process_student.php?action=delete&id=<?php echo $data['id'] ?>" onclick="return confirm('Are You Sure!')">Delete</a>
          </td>
          </td>
        </tr>
      <?php }
    } else { ?>
      <tr>
        <td>
          <h2 colspan="5">NO STUDENT DATA</h2>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>


<?php require_once 'inc/footer.php' ?>