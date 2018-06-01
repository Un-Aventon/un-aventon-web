<?php
mysqli_query($conexion,"UPDATE participacion set estado=2 where idParticipacion='$_POST[idParticipacion]'")
or die ("error en la actualizacion de estado");

 ?>
