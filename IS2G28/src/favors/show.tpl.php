<!DOCTYPE html>
<html>
<head>
  <title>Una Gauchada - Vista de un favor</title>
  <?php require '../common/common_headers.php'; ?>
  <script type="text/javascript" src="../js/show.js"></script> 
  <link type="text/css" rel="stylesheet" href="show.css">
  <script type="text/javascript" src="show.js"></script>
</head>
<body>
  <div class="container">
    <div id=header>
      <img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
    </div>
    <?php include('../common/menu.php'); ?>
    <div class="panel panel-default favor">
      <div class="panel-heading">
        <h3 class="panel-title">Ver una gauchada</h3>        
      </div>
      <div class="panel-body">        
        <div class="media favor">          
          <?php if ($favor): ?>
          <div class="media-left">
            <a href="#">
              <?php if ($favor->getPhoto()): ?>
                <img class="media-object img-rounded favor-photo" 
                     src="../uploads/<?php echo $favor->getPhoto() ?>" 
                     alt="<?php echo $favor->getTitle() ?>">
              <?php else: ?>
                <img class="media-object img-rounded favor-photo" 
                     src="../images/logo-gauchada.png" 
                     alt="Imagen de favor">
              <?php endif; 
              $owner = $favor->getOwner();?>
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading favor-title">
            <?php if (!$favor->getUnpublished()&& !$favor->getResolved()) {
	            echo $favor->getTitle();
	            if ($owner === $user) {
	            	?>
	            	<button class="btn btn-danger btn-xs pull-right" id="unpublish">Despublicar</button>
	            <?php }
            	} elseif ($favor->getResolved()) { ?>
					<?php echo $favor->getTitle();?>
	            	<span class="label label-success pull-right">Gauchada resuelta</span>
            <?php } else { ?>
					<del><?php echo $favor->getTitle();?></del>
	            	<span class="text text-danger">Gauchada despublicada</span>
            <?php }?>
            </h4>
            <p class="favor-description"><?php echo $favor->getDescription() ?></p>      
            <ul class="list-inline favor-properties">
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                  <?php echo $favor->getCity() ?>
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                  <?php echo $favor->getDeadline()->format('d/m/Y') ?>
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                  <a href="../profile/public.php?idUs=<?php echo $owner->getId(); ?>" class="text-white"><?php echo $owner ?></a>
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                  <?php echo count($favor->getQuestions()) ;?> pregunta<?=(count($favor->getQuestions()) == 1)?'':'s' ?>                  
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>
                  <?php $postulations = $favor->getMyPostulations();
                  $cantPostulations = $postulations->count();
                  if ($cantPostulations < 1 ) { ?>
					0 postulaciones
                  <?php } elseif ($owner === $user) {?>
					<a role="button" data-toggle="modal" href="#favorPostulationsWindow" class="text-white">
	                  	<?php echo $cantPostulations; 
	                  	if ( $cantPostulations > 1 ) {?> postulaciones 
                  		<?php } else { ?> postulaci&oacute;n 
                  		<?php } ?>
                  	</a>
                  <?php } else { ?>
	                  	<?php echo $cantPostulations; 
	                  	if ( $cantPostulations > 1 ) {?> postulaciones 
                  		<?php } else { ?> postulaci&oacute;n 
                  		<?php } ?>
                  <?php } ?>
                </span>            
              </li>        
            </ul>
            <!-- Boton para editar una gauchada (solo visible para el dueño de la misma) -->
            <?php if (($user === $favor->getOwner())&&($cantPostulations == 0 )&& !$favor->getUnpublished() && !$favor->getResolved()): ?>
            <a class="btn btn-primary" href="edit.php?id=<?= $favor->getId() ?>">
              <span class="glyphicon glyphicon-edit"></span> Editar gauchada
            </a>
            <?php endif; ?>
            
            <!-- Boton para calificar postulante que realizó gauchada -->
            <?php if (($user === $favor->getOwner()) && (!$favor->getPostulantQualification()) && ($favor->getResolved())): ?>
              <a class="btn btn-primary" data-toggle="modal" href="#qualification_modal">
                <span class="glyphicon glyphicon-screenshot"></span> Calificar postulante
              </a> 
              <p><strong> Resuelto por: <?php echo $favor->getAcceptedPostulant()->getName();?>
								    <span> <?php echo $favor->getAcceptedPostulant()->getLastname();?></span></strong></p>
              <?php include '../qualifications/form-qualification.tpl.php'; ?>
            <?php endif; ?>
            
            <div><?php 
            	$resuelta=$favor->getResolved();
            	$imPostulated = false; 
            	foreach ($postulations as $postulation) {
            		if ($postulation->getUser() === $user) {
            			$imPostulated = True;
            			$myPostulation = $postulation;
            		}
            	};
            	if ($owner !== $user) {
            		if (!$imPostulated) {
            			if (!$resuelta){
              			include '../postulations/commentPostulation.php';
            			}
            		} else { ?>
            			<span class="text bg-info pull-right">
            				Mi postulación está: <?php echo $myPostulation->getStatus();?>
               			</span>
               			<a class="btn btn-danger btn-xs pull-right btnDespost" id=<?php echo $myPostulation->getId();?>> 
   							<strong>Despostularme</strong> 
						</a>
               			<?php $idPost=$myPostulation->getId(); 
            		}
            	} ?>
            </div> 

          </div>
          <?php if ($owner === $user) {
          			include '../postulations/favorPostulations.php'; 
          		};?>
          <?php else: ?>
            <p>No existe la gauchada especificada.</p>
          <?php endif; ?>
        </div><!-- End .media.favor -->
                   
        <!-- Panel de preguntas y respuestas de la gauchada -->
        <div class="panel panel-default questions">
          <div class="panel-heading">Preguntas sobre la gauchada</div>
          <div class="panel-body">
            <?php if (count($favor->getQuestions()) === 0): ?>
              <p>No hay preguntas para esta gauchada.</p>
            <?php else: ?>
              <?php foreach ($favor->getQuestions() as $question): ?>
                <!-- Contenedor de pregunta/respuesta -->
                <div class="question-and-answer">
                 <!-- Contenedor de una pregunta -->
                  <div class="question">
                    <!-- Encabezado: Icono, autor, fecha/hora -->
                    <div class="question-header">
                      <span class="glyphicon glyphicon-comment pull-left"></span> 
                      <span class="question-author"><?php echo $question->getAuthor() ?></span>                
                      <span class="question-posted-at"><?php echo $question->getPostedAt()->format('d/m/Y \a \l\a\s H:i') ?></span>                
                    </div>
                    <!-- Contenido de la pregunta -->
                    <div class="question-content">
                      <?php echo $question->getContent() ?>                      
                    </div>
                    <!-- Incluir botón de respuesta si la pregunta no tiene respuesta y el usuario es el dueño de la guachada -->
                    <?php if (!$question->getAnswer() && ($favor->getOwner() === $user) && ($favor->isActive())): ?>
                      <!-- Boton para responder pregunta -->
                      <div class="clearfix">
                        <button class="btn btn-success btn-xs btn-answer pull-right <?php echo ((isset($newAnswer) && ($newAnswer->getQuestion() === $question))?'hidden':'') ?>">Responder</button>                        
                        <div class="new-answer <?php echo ((isset($newAnswer) && ($newAnswer->getQuestion() === $question))?'':'hidden') ?>">
                          <form action="answer-question.php" method="post">
                            <input type="hidden" id="answer_question_id" name="answer[question_id]" value="<?= $question->getId()?>">                            
                              <div class="form-group <?php echo (isset($answerErrors['content']) && ($newAnswer->getQuestion() === $question))?'has-error':'' ?>">
                                <label class="sr-only">Respuesta</label>
                                <textarea id="answer_content" name="answer[content]" class="form-control" rows="3" placeholder="Escriba su respuesta (hasta 255 caracteres)"><?= ((isset($newAnswer) && ($newAnswer->getQuestion() === $question))?$newAnswer->getContent():'') ?></textarea>
                                <?php if (isset($newAnswer) && $newAnswer->getQuestion() == $question): ?>
                                  <!-- Contenedor del mensaje de error -->
                                  <span class="error help-block <?php echo isset($answerErrors['content'])?'shown':'hidden' ?>">
                                    <?php echo isset($answerErrors['content'])?$answerErrors['content']:'' ?>
                                  </span>  
                                <?php endif; ?>
                              </div>
                            
                            <button type="submit" class="btn btn-info btn-xs pull-right">Enviar respuesta</button>
                          </form> 
                          
                        </div>
                      </div>
                    <?php endif; ?>
                  </div> <!-- End .question -->
                  <?php if ($question->getAnswer()): ?>
                    <!-- Contenedor de una respuesta -->
                    <div class="answer">
                       <!-- Encabezado: Icono, autor, fecha/hora -->
                      <div class="answer-header">
                        <span class="glyphicon glyphicon-comment pull-left"></span> 
                        <span class="answer-author"><?php echo $question->getFavor()->getOwner() ?></span>                
                        <span class="answer-posted-at">
                          <?php echo $question->getAnswer()->getPostedAt()->format('d/m/Y \a \l\a\s H:i') ?>
                        </span>                
                      </div>
                      <!-- Contenido de la pregunta -->
                      <div class="answer-content">
                        <?php echo $question->getAnswer()->getContent() ?>
                      </div>
                    </div> <!-- End .answer -->
                  <?php endif; ?>
              </div>                         
              <?php endforeach; ?>
            <?php endif; ?>
            
            <!-- Mostrar formulario para nueva pregunta si el favor es publico (no vencido, no aceptado, no despublicado) y no le pertenece al usuario -->
            <?php if (($favor->isActive()) && ($favor->getOwner() !== $user)): ?>
              <!-- Panel que incluye formulario de nueva pregunta -->
              <div class="ask-question clearfix">
                <form action="ask.php" method="post">
                  <input type="hidden" id="question_favor_id" name="question[favor_id]" value="<?= $favor->getId()?>">                
                  <div class="form-group <?php echo isset($errors['content'])?'has-error':'' ?>">
                    <label class="sr-only">Pregunta</label>
                    <textarea id="question_content" name="question[content]" class="form-control" rows="3" placeholder="Escriba una pregunta (hasta 255 caracteres)"><?= isset($newQuestion)?$newQuestion->getContent():'' ?></textarea>
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block <?php echo isset($errors['content'])?'shown':'hidden' ?>">
                      <?php echo isset($errors['content'])?$errors['content']:'' ?>
                    </span>  
                  </div>
                  <button type="submit" class="btn btn-info pull-right">Preguntar</button>
                </form>              
              </div> <!-- End .ask-question -->
            <?php endif; ?>
          </div>
        </div>
        
        
        <br>        
        <a class="btn btn-default" href="list.php">Volver al listado</a>
      </div><!-- End .panel-body -->
      
    </div>
    
  </div>
  
    
</body>
</html>
