<?php include 'access_control.php'; ?>

<?php
  if($_SESSION['admin'] == 0 or !isset($_SESSION['admin'])) {
    $newURL = "http://138.68.46.83/crud/index.php";
    header('Location: '.$newURL);
  }
?>

<?php if (isset($_GET['delete_user'])): ?>

  <?php
    // redirect to ask for confirmation_delete
    $newURL = "http://138.68.46.83/crud/confirmation_delete.php?delete_id=".$_GET['id']."&user_name_to_delete=".$_GET['delete_user_name']."";
    header('Location: '.$newURL);

    //$newURL = "http://138.68.46.83/crud/delete_user_table.php?delete_id=".$_GET['id']."";
    //header('Location: '.$newURL);
  ?>

<?php elseif (isset($_GET['add_user'])): ?>
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>v2.1 Admin Page</title>
      <?php
        include('header.php');
      ?>
    </head>
    <body>
      <div class="nav-container">
        <ul>
          <li><a href="./landing.php"><div>Soundboards</div></a>
            <div>
              <ul>
                <li><a href="./landing.php">Public</a></li>
                <?php if(isset($_SESSION['email'])): ?>
                  <li><a href="./private_SB.php">Private</a></li>
                <?php endif; ?>
              </ul>
            </div>
          </li>
          <?php if(isset($_SESSION['email'])): ?>
            <li><a href="./logout.php"><div>Log Out</div></a>
            </li>
          <?php endif; ?>
          <?php if ($_SESSION['admin']=='1'): ?>
            <li><a href="./admin_page.php"><div>Admin</div></a>
            </li>
          <?php endif ?>
        </ul>
        <?php
          echo '<p class="login" id="hello">Hello, '. $_SESSION['first_name'] .'</p>';
        ?>
      </div>
      <?php
      $get_all_non_admin = "SELECT user_id, username, password, first_name, last_name, email FROM users WHERE admin = '0'";
      $user_table_result = $conn->query($get_all_non_admin);

      if (!$user_table_result) {
        echo "<h1>A Database error occurred while querying all non-admin users from database</h1>";
      } else {
        $user_table_row = $user_table_result->fetch_array(MYSQLI_NUM);
        if ($user_table_row) {
          // User table was returned from database with at least one row
          echo "<table>";
          echo   "<tr>";
          echo     "<th>user-id</th>";
          echo     "<th>username</th>";
          echo     "<th>password</th>";
          echo     "<th>first name</th>";
          echo     "<th>last name</th>";
          echo     "<th>email</th>";
          echo   "</tr>";
          echo   "<tr>";
          echo     "<th>" . $user_table_row[0] . "</th>";
          echo     "<th>" . $user_table_row[1] . "</th>";
          echo     "<th>" . $user_table_row[2] . "</th>";
          echo     "<th>" . $user_table_row[3] . "</th>";
          echo     "<th>" . $user_table_row[4] . "</th>";
          echo     "<th>" . $user_table_row[5] . "</th>";
          echo     "<td><a href='admin_page.php?delete_user=1&id=".$user_table_row[0]."'><button>Delete</button></a></td>";
          echo     "<td><a href='admin_page.php?edit_user=1&id=".$user_table_row[0]."'><button>Edit</button></a></td>";
          echo   "</tr>";
          while ($user_table_row = $user_table_result->fetch_array(MYSQLI_NUM)) {
            echo   "<tr>";
            echo     "<th>" . $user_table_row[0] . "</th>";
            echo     "<th>" . $user_table_row[1] . "</th>";
            echo     "<th>" . $user_table_row[2] . "</th>";
            echo     "<th>" . $user_table_row[3] . "</th>";
            echo     "<th>" . $user_table_row[4] . "</th>";
            echo     "<th>" . $user_table_row[5] . "</th>";
            echo     "<td><a href='admin_page.php?delete_user=1&id=".$user_table_row[0]."'><button>Delete</button></a></td>";
            echo     "<td><a href='admin_page.php?edit_user=1&id=".$user_table_row[0]."'><button>Edit</button></a></td>";
            echo   "</tr>";
          }
          echo "</table";
        } else {
          // User table was returned from database with no rows. Do not display anything.
          echo "No non-admin users to show";
        }
      }
      ?>
    </form>
      <form method="post" action="add_user_table.php">
        <label for="user_name">User-name:</label>
        <input type="text" name="user_name_to_add">
        <label for="password">Password:</label>
        <input type="password" name="password_to_add">
        <label for="user_first_name">First Name:</label>
        <input type="text" name="first_name_to_add">
        <label for="user_last_name">Last Name:</label>
        <input type="text" name="last_name_to_add">
        <label for="user_email">Email Address:</label>
        <input type="text" name="user_email_to_add">
        <input type="submit" name="add_user_button" value="Add User">
      </form>
    </body>
  </html>

<?php elseif (isset($_GET['edit_user'])): ?>

  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>Admin Page</title>
      <link rel="stylesheet" href="./sb_main.css">
      <link rel="stylesheet" href="./sb.css">
      <script src="./sb_main.js"></script>
    </head>
    <body>
      <div class="nav-container">
        <ul>
          <li><a href="/crud/index.php"><div>Soundboards</div></a>
            <div>
              <ul>
                <li><a href="/crud/index.php">Public</a></li>
                <?php
                  if($_SESSION['user_email']){
                    echo '<li><a href="/crud/private_SB.php">Private</a></li>';
                  }
                ?>
              </ul>
            </div>
          </li>
          <?php if (isset($_SESSION['user_email'])): ?>
            <li><a href="/crud/log_out.php"><div>Log Out</div></a>
            </li>
          <?php endif ?>
        </ul>
        <?php
          if($_SESSION['user_email']){
            echo '<p class="login" id="hello">'. $_SESSION['user_first_name'] .'</p>';
          }

          else{
            echo '<form id="register" action="/crud/registration.php" method="get">
              <input type="submit" value="Register">
            </form>
            <form class="login" action="/crud/login.php" method="get">
              <input type="submit" value="Login">
            </form>';
          }
        ?>
       </div>
      <?php
      $get_all_non_admin = "SELECT user_id, username, password, first_name, last_name, email FROM users WHERE admin = '0'";
      $user_table_result = $conn->query($get_all_non_admin);

      if (!$user_table_result) {
        echo "<h1>A Database error occurred while querying all non-admin users from database</h1>";
      } else {
        $user_table_row = $user_table_result->fetch_array(MYSQLI_NUM);
        if ($user_table_row) {
          // User table was returned from database with at least one row
          echo "<table>";
          echo   "<tr>";
          echo     "<th>user-id</th>";
          echo     "<th>username</th>";
          echo     "<th>password</th>";
          echo     "<th>first name</th>";
          echo     "<th>last name</th>";
          echo     "<th>email</th>";
          echo     "<th><a href='admin_page.php?add_user=1'><button>Add User</button></a></th>";
          echo   "</tr>";
          echo   "<tr>";
          echo     "<th>" . $user_table_row[0] . "</th>";
          echo     "<th>" . $user_table_row[1] . "</th>";
          echo     "<th>" . $user_table_row[2] . "</th>";
          echo     "<th>" . $user_table_row[3] . "</th>";
          echo     "<th>" . $user_table_row[4] . "</th>";
          echo     "<th>" . $user_table_row[5] . "</th>";
          echo     "<td><a href='admin_page.php?delete_user=1&id=".$user_table_row[0]."'><button>Delete</button></a></td>";
          echo     "<td><a href='admin_page.php?edit_user=1&id=".$user_table_row[0]."'><button>Edit</button></a></td>";
          echo   "</tr>";
          while ($user_table_row = $user_table_result->fetch_array(MYSQLI_NUM)) {
            echo   "<tr>";
            echo     "<th>" . $user_table_row[0] . "</th>";
            echo     "<th>" . $user_table_row[1] . "</th>";
            echo     "<th>" . $user_table_row[2] . "</th>";
            echo     "<th>" . $user_table_row[3] . "</th>";
            echo     "<th>" . $user_table_row[4] . "</th>";
            echo     "<th>" . $user_table_row[5] . "</th>";
            echo     "<td><a href='admin_page.php?delete_user=1&id=".$user_table_row[0]."'><button>Delete</button></a></td>";
            echo     "<td><a href='admin_page.php?edit_user=1&id=".$user_table_row[0]."'><button>Edit</button></a></td>";
            echo   "</tr>";
          }
          echo "</table";
        } else {
          // User table was returned from database with no rows. Do not display anything.
          echo "No non-admin users to show";
        }
      }
      ?>
    </form>
      <form id="edit_form_id" action="edit_user_table.php" method="post">
        <label for="user_name">User-name:</label>
        <input type="text" name="user_name">
        <label for="password">Password:</label>
        <input type="password" name="user_password">
        <label for="user_first_name">First Name:</label>
        <input type="text" name="user_first_name">
        <label for="user_last_name">Last Name:</label>
        <input type="text" name="user_last_name">
        <label for="user_email">Email Address:</label>
        <input type="text" name="user_email">
        <input type="hidden" name="user_id_to_edit" value="<?php echo $_GET['id']; ?>">
        <input type="submit" name="edit_user_button" value="Edit User">
      </form>
    </body>
  </html>

<?php else: ?>

  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>Admin Page</title>
      <link rel="stylesheet" href="./sb_main.css">
      <link rel="stylesheet" href="./sb.css">
      <script src="./sb_main.js"></script>
    </head>
    <body>
      <div class="nav-container">
        <ul>
          <li><a href="/crud/index.php"><div>Soundboards</div></a>
            <div>
              <ul>
                <li><a href="/crud/index.php">Public</a></li>
                <?php
                  if($_SESSION['user_email']){
                    echo '<li><a href="/crud/private_SB.php">Private</a></li>';
                  }
                ?>
              </ul>
            </div>
          </li>
          <?php if (isset($_SESSION['user_email'])): ?>
            <li><a href="/crud/log_out.php"><div>Log Out</div></a>
            </li>
          <?php endif ?>
        </ul>
        <?php
          if($_SESSION['user_email']){
            echo '<p class="login" id="hello">'. $_SESSION['user_first_name'] .'</p>';
          }

          else{
            echo '<form id="register" action="/crud/registration.php" method="get">
              <input type="submit" value="Register">
            </form>
            <form class="login" action="/crud/login.php" method="get">
              <input type="submit" value="Login">
            </form>';
          }
        ?>
       </div>
      <?php
      $get_all_non_admin = "SELECT user_id, username, password, first_name, last_name, email FROM users WHERE admin = '0'";
      $user_table_result = $conn->query($get_all_non_admin);

      if (!$user_table_result) {
        echo "<h1>A Database error occurred while querying all non-admin users from database</h1>";
      } else {
        $user_table_row = $user_table_result->fetch_array(MYSQLI_NUM);
        if ($user_table_row) {
          // User table was returned from database with at least one row
          echo "<table>";
          echo   "<tr>";
          echo     "<th>user-id</th>";
          echo     "<th>username</th>";
          echo     "<th>password</th>";
          echo     "<th>first name</th>";
          echo     "<th>last name</th>";
          echo     "<th>email</th>";
          echo     "<th><a href='admin_page.php?add_user=1'><button>Add User</button></a></th>";
          echo   "</tr>";
          echo   "<tr>";
          echo     "<th>" . $user_table_row[0] . "</th>";
          echo     "<th>" . $user_table_row[1] . "</th>";
          echo     "<th>" . $user_table_row[2] . "</th>";
          echo     "<th>" . $user_table_row[3] . "</th>";
          echo     "<th>" . $user_table_row[4] . "</th>";
          echo     "<th>" . $user_table_row[5] . "</th>";
          echo     "<td><a href='admin_page.php?delete_user=1&id=".$user_table_row[0]."&delete_user_name=".$user_table_row[1]."'><button>Delete</button></a></td>";
          echo     "<td><a href='admin_page.php?edit_user=1&id=".$user_table_row[0]."'><button>Edit</button></a></td>";
          echo   "</tr>";
          while ($user_table_row = $user_table_result->fetch_array(MYSQLI_NUM)) {
            echo   "<tr>";
            echo     "<th>" . $user_table_row[0] . "</th>";
            echo     "<th>" . $user_table_row[1] . "</th>";
            echo     "<th>" . $user_table_row[2] . "</th>";
            echo     "<th>" . $user_table_row[3] . "</th>";
            echo     "<th>" . $user_table_row[4] . "</th>";
            echo     "<th>" . $user_table_row[5] . "</th>";
            echo     "<td><a href='admin_page.php?delete_user=1&id=".$user_table_row[0]."&delete_user_name=".$user_table_row[1]."'><button>Delete</button></a></td>";
            echo     "<td><a href='admin_page.php?edit_user=1&id=".$user_table_row[0]."'><button>Edit</button></a></td>";
            echo   "</tr>";
          }
          echo "</table";
        } else {
          // User table was returned from database with no rows. Do not display anything.
          echo "No non-admin users to show";
        }
      }
      ?>
      </form>
    </body>
  </html>

<?php endif ?>
