<?php
include "../db.php";

$result = mysqli_query($conn,"SELECT * FROM services ORDER BY service_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Services</title>

  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="top-bar">
  <h2>Services</h2>

  <a href="services_add.php" class="btn">
    + Add Service
  </a>
</div>

<table>

  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Rate</th>
    <th>Status</th>
    <th>Action</th>
  </tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

  <td><?= $row['service_id']; ?></td>

  <td><?= htmlspecialchars($row['service_name']); ?></td>

  <td>₱<?= number_format($row['hourly_rate'],2); ?></td>

  <td>
    <span class="status <?= $row['is_active'] ? 'active':'inactive'; ?>">
      <?= $row['is_active'] ? 'Active':'Inactive'; ?>
    </span>
  </td>

  <td class="actions">
    <a href="services_edit.php?id=<?= $row['service_id']; ?>">
      Edit
    </a>
  </td>

</tr>

<?php } ?>

</table>

</body>
</html>