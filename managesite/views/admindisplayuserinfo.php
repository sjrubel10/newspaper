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
        //    $usersDataHtml .= '<div class=""> <span class="">'.$userData['username'].'</span> </div>';
        $usersDataHtml .= '<tr id="user_' . $userData['userkey'] . '">
                                <td>' . $userData['first_name'].' '.$userData['last_name']. '</td>
                                <td>' . $userData['username'] . '</td>
                                <td>' . $userData['mail'] . '</td>
                                <td><input type="checkbox"></td>
                                <td>
                                    <select>
                                        <option value="superadmin">Super Admin</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Modaretor</option>
                                    </select>
                                </td>
                                <td><button>Delete</button></td>
                                <td><button id="'.$userData['userkey'].'">Submit</button></td>
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



