<?php
//var_test( $usersData );

$usersDataHtml = '';
if( count( $usersData ) > 0 ) {
    $usersDataHtml = '<table>  
                    <thead> 
                        <tr> 
                            <th>Name</th>
                            <th>Username</th>
                            <th>Mail</th>
                            <th>Make Admin</th>
                            <th>Admin Level</th>
                            <th>Delete from Admin</th>
                            <th>Action</th>
                        </tr>
                    </thead>';
    foreach ($usersData as $key => $userData) {
        if( $userData['admin'] == 1 ){
            $is_checked = 'checked';
        }else{
            $is_checked = '';
        }
        //    $usersDataHtml .= '<div class=""> <span class="">'.$userData['username'].'</span> </div>';
        $usersDataHtml .= '<tr id="user_' . $userData['userkey'] . '">
                                <td>' . $userData['first_name'].' '.$userData['last_name']. '</td>
                                <td>' . $userData['username'] . '</td>
                                <td>' . $userData['mail'] . '</td>
                                <td><input id="isAdmin_'.$userData['userkey'].'" type="checkbox" '.$is_checked.' ></td>
                                <td>
                                    <select id="adminlevel_'.$userData['userkey'].'">
                                       <!--  <option value="1">Super Admin</option> -->
                                        <option value="2">Admin</option>
                                        <option value="3">Modaretor</option>
                                    </select>
                                </td>
                                <td><div class="removeFromAdmin" id="delete_'.$userData['userkey'].'">Delete</div></td>
                                <td><div id="make_'.$userData['userkey'].'" class="makeAdminSubmit">Submit</div></td>
                            </tr>';
    }

    $usersDataHtml .= '</tbody></table>';
}else{
    $usersDataHtml .= '<div class="emptyUserList">No User Found</div>';
}

echo $usersDataHtml;
?>

<style>
    table {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>



