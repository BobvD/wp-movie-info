(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($) {

		$("#movie-info-search-button").click(function (e) {
			e.preventDefault();
			$(this).addClass( "disabled" );
			$(this).html('<span class="dashicons dashicons-search"></span>Searching...');
			$(".movie-info-table td").parent().remove();
			$( ".movie-info-table" ).before('<span class="searching">Searching...</span>');
			var movie = $.trim($('#post_movie').val());
			var year = $.trim($('#post_movie_year').val());
			var request = 'action=get_movie_names&movie='+movie;
			if(year){
				request += ('&year=' + year);
			}

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '/wpdev/wp-admin/admin-ajax.php',
				data: request,
				success:function(data) {
					if(data && data == "")
						$( ".movie-info-table" ).append('<tr><td>No Results.</td></tr>');
					else
						data.forEach(printMovie);
					$(".searching").remove();
					$( ".movie-info-table" ).show();
					$("#movie-info-search-button").removeClass( "disabled" );
					$("#movie-info-search-button").html('<span class="dashicons dashicons-search"></span>Search');

				  },
				error: function (xhr, ajaxOptions, thrownError) {
					$(".searching").remove();
				}
			});
		});

		function printMovie(data){
			$( ".movie-info-table" ).append( `<tr data-movie-title="${data['Title']}" data-movie-id="${data['imdbID']}" data-movie-year="${data['Year']}">
												<td>
												${data['Title']}
												</td>
												<td>
												${data['Year']}</td>
												<td><a href="#" id="post_movie_add"> Add</a></tr>` );
		}

		$(document).on('click', '#post_movie_add', function(e) {
			e.preventDefault();
			var par = $(e.target).parent().parent();
			var title = par.data('movie-title');
			var id = par.data('movie-id');
			var year = par.data('movie-year');

			$( ".movie-info-tags" ).append(`<input type="hidden" name="post_movie[]" value="${title + ' (' + year})" />`);
			$( ".movie-info-tags ul" ).append(`<li data-movie-tag='"${title + ' (' + year})"'><button type="button dashicons-before" class="movie-info-delete">
												<span class="dashicons dashicons-dismiss" aria-hidden="true"></span>
		 										</button>${title + ' (' + year})</li>`);
		});

		$(document).on('click', '.movie-info-delete', function(e) {
			e.preventDefault();
			var par = $(e.target).parent().parent();
			var tag = par.data('movie-tag');
			if ( $(  "input[value='" + tag + "']" ).length ) {
				$( "input[value='" + tag + "']").remove();
			}
			$( ".movie-info-tags" ).append(`<input type="hidden" name="post_movie_deleted[]" value="${tag}" />`);
			$(par).remove()
		});

	});

	jQuery(document).ready(function() {
		var $ = jQuery;
		var media_uploader = null;
		if ($('.set_custom_images').length > 0) {
			if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
				$(document).on('click', '.set_custom_images', function(e) {
					e.preventDefault();
					var button = $(this);
					var id = button.prev();

					media_uploader = wp.media({
						frame:    "post",
						state:    "insert",
						multiple: false
					});

					media_uploader.on("insert", function(){
						var json = media_uploader.state().get("selection").first().toJSON();

						var image_url = json.url;
						console.log(image_url);
						$("#movie-info-poster").attr("src",image_url);
						$("#poster").attr("value",image_url);
						var image_caption = json.caption;
						var image_title = json.title;
					});

					media_uploader.open(button);
					return false;
				});
			}
		}
	});

})( jQuery );
