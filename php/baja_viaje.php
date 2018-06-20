<?php
    mysqli_query($conexion, "UPDATE vehiculo set eliminado=1 where idVehiculo=$id")or die('error '.mysqli_error($conexion));
?>





<div class="modal fade" id="<?php echo "EliminarViaje$idViaje"?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel">Cancelar Viaje</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								      	<?php if(!$hayParticipaciones){
								      		?>
								      			<div class="alert alert-warning" role="alert">
  													¿Estas Completamente seguro de que deseas eliminar el viaje? Esta accion será irreversible.
												</div>
											<?php
								      		   }
								      		   else{
								      			?>
								      			<div class="alert alert-danger" role="alert">
  													Ya aceptaste a copilotos para este viaje, la cancelacion de este viaje provocará que se te resten 2 puntos de tu calificación general, ¿Estas Completamente seguro de que deseas eliminar el viaje?
												</div>
												<?php
								      		}
								      		?>
								      </div>
								      <div class="modal-footer">
                                        <div class="row">
                                            <div class="col col-md-6">
                                                <form action="/perfil" method="post">
                                                	<button type="submit" class="btn btn-danger" value="<?php echo "$viaje[idVehiculo]"?>">Eliminar</button>
                                                </form>
                                            </div>
                                            <div class="col col-md-6">
                           						<button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
								       	 </div>
								      </div>
								    </div>
								  </div>
								</div>
							</div>

								<!-- End Modal -->