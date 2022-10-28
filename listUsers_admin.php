<?php


include 'requete.php';
include '_headerBar.php';
$users= json_decode(GetAllUsers(),true);
?>




<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <br>
                <h4>List de Usagers</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Adresse</th>
                            <th>Role</th>
                            <th>Changer</th>
                            <th>Bloque</th>
                            <th>Supprimer</th>
                        </tr>
                        <?php
                            foreach ($users as $user)
                            {
                                echo "<tr>";
                                echo "<th>". $user['id'] ."\n"."</th>";
                                echo "<th>". $user['nom'] ."\n"."</th>";
                                echo "<th>". $user['prenom'] ."\n"."</th>";
                                echo "<th>". $user['email'] ."\n"."</th>";
                                echo "<th>". $user['telephone'] ."\n"."</th>";
                                echo "<th>". $user['adresse'] ."\n"."</th>";
                                
                                if($user['idRole'] == '2')
                                {
                                    echo "<th>Admin</th>";
                                }
                                elseif($user['idRole'] == '1')
                                {
                                    echo "<th>User</th>";
                                }
                                ?>
                                
                                
                                <th>hola</th>
                                <th>
                                    <form action='adminAction.php' method='POST'>
                                        <button type='submit' name='user_block' value=<?=$user['id'] ?> class='btn btn-danger'>Block</button>
                                    </form>
                                </th>
                                <th>
                                    <form action='adminActions.php' method='POST'>
                                        <button type='submit' name='user_delete' value=<?=$user['id'] ?> class='btn btn-danger'>Supprimer</button>
                                    </form>
                                </th>
                                
                                <?php
                                echo "<tr>";  
                            }
                        ?>        
                            
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</body>