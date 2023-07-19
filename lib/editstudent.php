<?php
require_once '../inc/header.php';
require 'dataBase.php';
?>
<link rel="stylesheet" href="../inc/style.css">

<?php
$id = $_GET['id'];
$db = new Database();
$table = "tbl_student";
$whereCond = array(
  'where' => array('id' => $id),
  'return_type' => 'single'
);
$value = $db->select($table, $whereCond);

if (!empty($value)) {

?>
  <div class="container">
    <div>
      <h2 class="data"><strong>Update Data</strong>
        <a class=" float-right button add-btn" href="../index.php">
          Back
        </a>
    </div>
    <form action="process_student.php" method="post">
      <fieldset>
        <div>
          <label for="name">Student Name</label>
          <input type="text" name="name" id="name" required='1' value="<?php echo $value['name']; ?>">
        </div>

        <div>
          <label for="email">Student Email</label>
          <input type="text" name="email" id="email" required='1' value="<?php echo $value['email']; ?>">
        </div>

        <div>
          <label for=" phone">Student Phone</label>
          <input type="text" name="phone" id="phone" required='1' value="<?php echo $value['phone']; ?>">
        </div>

        <div>
          <input type=" hidden" name="id" value="<?php echo $value['id']; ?>">

          <input type=" hidden" name="action" value="Edit">
          <input type="submit" name="submit" value="Update Student">
        </div>
      </fieldset>
    </form>
  <?php } ?>
  </div>
  <?php require_once '../inc/footer.php' ?>