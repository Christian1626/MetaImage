
<!-- ================================================================ -->
<!--                     DETAILS D'UNE IMAGE                          -->
<!-- ================================================================ -->

<div class="centrer">
	<h1><?= $image->title ?></h1>
	<img src="img/<?= $image->fileName ?>" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
</div><br/><br/>

<div class="container">
	<div class="row row-centered">
		<?php if (!empty($image->latitude) && !empty($image->longitude)) { ?>
		<div class="col-xs-8 col-centered col-max">
			<?php} else { ?>
			<div class="col-xs-12 col-centered col-max">
				<?php } ?>
				<div class="item">
					<div class="content">
						<form class="form-horizontal" role="form" method="post" action="index.php?p=modify&imageName=<?=$image->name?>" >
							<div class="form-group">
								<label class="control-label col-sm-2" for="filename">Title :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_title_photo" name="old_title_photo" value="<?= $image->title ?>" >
									<input type="text" class="form-control" id="title_photo" name="title_photo" autocomplete="off" value="<?= $image->title ?>" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="description">Description:</label>
								<div class="col-sm-10" >
									<input type="hidden" id="old_ImageDescription" name="old_ImageDescription" value="<?= $image->description ?>" >
									<textarea class="form-control custom-control" rows="3" style="resize:none" autocomplete="off" name="ImageDescription"><?= $image->description ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="keywords">Keywords :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_keyword" name="old_keywords" value="<?= $image->keywords ?>" >
									<input type="text" class="form-control" id="keyword" name="keywords" autocomplete="off" value="<?= $image->keywords ?>" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="copyright">Copyright :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_copyright" name="old_copyright" value="<?= $image->copyright ?>" >
									<input  type="text" class="form-control" id="copyright" name="copyright" autocomplete="off" value="<?= $image->copyright ?>" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="artist">Artist :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_artist" name="old_artist" value="<?= $image->artist ?>" >
									<input type="text" class="form-control" id="artist" name="artist" autocomplete="off" value="<?= $image->artist ?>" >
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-warning" name="EnvoyerModif">Modifier</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>

		<?php if (!empty($image->latitude) && !empty($image->longitude)) { ?>
		<div class="col-xs-4 col-centered col-max">
			<div class="item">
				<div class="content">
					<google-map latitude="37.77493" longitude="-122.41942" fit-to-markers>
					<google-map-marker latitude="<?= $image->latitude ?>" longitude="<?= $image->longitude ?>"></google-map-marker>
				</google-map>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>

	<div class="container">
		<div class="row row-centered">
			<div class="col-xs-12 col-centered col-max">
				<div id="accordion">
					<div id="headingZero" class="panel-heading">
						<h4 class="panel-title"><a href="#collapseZero" data-toggle="collapse" data-parent="#accordion">Cliquez pour afficher toutes les métadonnées de l'image</a></h4>
					</div>

					<div id="collapseZero" class="panel-collapse collapse">
						<div class="panel-body">
							<pre>
								<?php 
								 print_r($image->data); ?>
							</pre>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


		
