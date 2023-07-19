  <?php require_once '../inc/header.php' ?>

  <link rel="stylesheet" href="../inc/style.css">

  <div class="container">
    <div>
      <h2 class="data"><strong>Student Data</strong>
        <a class=" float-right button add-btn" href="../index.php">
          Back
        </a>
    </div>
    <form action="process_student.php" method="post">
      <fieldset>
        <div>
          <label for="name">Student Name</label>
          <input type="text" name="name" id="name" required>
        </div>

        <div>
          <label for="email">Student Email</label>
          <input type="text" name="email" id="email" required>
        </div>

        <div>
          <label for="phone">Student Phone</label>
          <input type="text" name="phone" id="phone" required>
        </div>

        <div>
          <input type="hidden" name="action" value="Add">
          <input type="submit" name="submit" value="Add Student">
        </div>

      </fieldset>
    </form>
    <div>

    </div>
  </div>
  <?php require_once '../inc/footer.php' ?>