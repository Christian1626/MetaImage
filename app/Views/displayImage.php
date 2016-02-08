<!-- ================================================================ -->
<!--                     DETAILS D'UNE IMAGE                          -->
<!-- ================================================================ -->

<div class="centrer">
	<h1><?= $title ?></h1>
	<img src="img/<?= $fileName ?>" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
</div><br/><br/>

<div class="container">
	<div class="row row-centered">
		<?php if (!empty($latitude) && !empty($longitude)) { ?>
		<div class="col-xs-8 col-centered col-max">
			<?php} else { ?>
			<div class="col-xs-12 col-centered col-max">
				<?php } ?>
				<div class="item">
					<div class="content" itemtype="http://schema.org/Photograph" itemscope>
						<form class="form-horizontal" role="form" method="post">
							<div class="form-group">
								<label class="control-label col-sm-2" for="filename">Title :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_title_photo" name="old_title_photo" value="<?= $title ?>" >
									<input itemprop="about" type="text" class="form-control" id="title_photo" name="title_photo" value="<?= $title ?>" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="description">Description:</label>
								<div class="col-sm-10" >
									<input type="hidden" id="old_ImageDescription" name="old_ImageDescription" value="<?= $description ?>" >
									<textarea itemprop="description" class="form-control custom-control" rows="3" style="resize:none" name="ImageDescription"><?= $description ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="keywords">Keywords :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_keyword" name="old_keywords" value="<?= $keywords ?>" >
									<input itemprop="keywords" type="text" class="form-control" id="keyword" name="keywords" value="<?= $keywords ?>" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="copyright">Copyright :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_copyright" name="old_copyright" value="<?= $copyright ?>" >
									<input itemprop="copyrightHolder" type="text" class="form-control" id="copyright" name="copyright" value="<?= $copyright ?>" >
								</div>
							</div>

							<div class="form-group" itemprop="creator" itemscope itemtype="http://schema.org/Person">
								<label class="control-label col-sm-2" for="artist">Artist :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_artist" name="old_artist" value="<?= $artist ?>" >
									<input itemprop="givenName" type="text" class="form-control" id="artist" name="artist" value="<?= $artist ?>" >
								</div>
							</div>


							<?php //metadataImage($data, $description, $copyright, $artist, $listeKW); ?>

						<!-- </div> -->

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-warning" name="EnvoyerModif" onclick="return confirm(\'Appliquer définitivement les modifications aux metadatas de :\n <?= $title ?> ?\')">Modifier</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>

		<?php if (!empty($latitude) && !empty($longitude)) { ?>
		<div class="col-xs-4 col-centered col-max">
			<div class="item">
				<div class="content">
					<google-map latitude="37.77493" longitude="-122.41942" fit-to-markers>
					<google-map-marker latitude="<?= $latitude ?>" longitude="<?= $longitude ?>"></google-map-marker>
				</google-map>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>


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
							 print_r($fullinfo); ?>
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
