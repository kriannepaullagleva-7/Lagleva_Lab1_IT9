<?php
include "../db.php";

$id = $_GET['id'];

$q = mysqli_query($conn,"SELECT * FROM services WHERE service_id='$id'");
$row = mysqli_fetch_assoc($q);

$msg = "";

if(isset($_POST['update'])){

  $name = $_POST['service_name'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];

  mysqli_query($conn,"
    UPDATE services SET
    service_name='$name',
    hourly_rate='$rate',
    is_active='$active'
    WHERE service_id='$id'
  ");

  $msg = "Service updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Service</title>

  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Edit Service</h2>

<?php if($msg){ ?>
  <div class="success"><?= $msg ?></div>
<?php } ?>

<form method="post">

  <label>Service Name</label>
  <input type="text" name="service_name"
         value="<?= htmlspecialchars($row['service_name']); ?>"
         required>

  <label>Hourly Rate</label>
  <input type="number" step="0.01"
         name="hourly_rate"
         value="<?= $row['hourly_rate']; ?>"
         required>

  <label>Status</label>
  <select name="is_active">

    <option value="1"
      <?= $row['is_active']?'selected':'' ?>>
      Active
    </option>

    <option value="0"
      <?= !$row['is_active']?'selected':'' ?>>
      Inactive
    </option>

  </select>

  <button class="btn" type="submit" name="update">
    Update Service
  </button>

  <br><br>

  <a href="services_list.php" class="btn">
    ← Back
  </a>

</form>

</body>
</html>