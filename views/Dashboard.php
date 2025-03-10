<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    table, th, td {
      text-align: left;
      border: 1px solid;
    }
  </style>
  <title>Dashboard</title>
</head>
<body>
  <h1>Dashboard</h1>
  <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>

  <form method="POST" action="addStudent">
    <h4>Add a student</h4>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required placeholder="Enter student name">
    <input type="text" id="email" name="email" required placeholder="Enter student email">
    <button type="submit">Add Student</button>
  </form>

  <div>
    <h2>Students</h2>
    <?php if (count($students) == 0) { ?>
      <p>No students found.</p>
    <?php } else { ?> 
      <table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Manage</th>
        </tr>  
      <?php foreach ($students as $student) { ?>
        <tr>
          <td><?php echo $student["id"] ?></td>
          <td><?php echo $student["name"] ?></td>
          <td><?php echo $student["email"] ?></td>
          <td>
            <form method="POST" action="deleteStudent">
              <input type="hidden" name="id" value="<?php echo $student["id"]; ?>">
              <button type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php } ?>
      </table>
    <?php } ?>
  </div>

  <a href="logout">Logout</a>
  
</body>
</html>