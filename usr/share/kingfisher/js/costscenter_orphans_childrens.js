/*

    Orphans user e Childrens user functions ( For CostsCenter )

*/


// CostsCenter

// Get Orphans
function get_orphans_costscenter() {

	$.ajax({
				
		type: "GET",
		url: "./ajax/orphans_users.php",
		dataType: "xml",
		data: "type=costscenter",
		success: function(xml) {
			get_orphans_result_costscenter(xml);
		}

	});

}


// Alter orphans to childrens and childrens to orphans
function alter_or_ch_costscenter(id, costcenter_id) {

	$.ajax({
				
		type: "GET",
		url: "./ajax/alter_or_ch_costscenter.php",
		dataType: "html",
		data: "id=" + id + "&costcenter_id=" + costcenter_id,
		success: function(html) {
			update_state_costscenter(html);
		}

	});

}


// Receive orphans list and show
function get_orphans_result_costscenter(xml) {

	$('div#orphans_data').html('');

	$(xml).find('user').each(function() {
		
		var id_user = $(this).find('id').text();
		var name_user = $(this).find('name').text()
		var id_costcenter = $('input#costcenter').val();

		$('div#orphans_data').append('<li><a href="#" OnClick="alter_or_ch_costscenter(' + id_user + ', ' + id_costcenter + ')">' + name_user + '</a></li>');		

	});

}


// Get childrens
function get_childrens_costscenter() {

	$.ajax({
				
		type: "GET",
		url: "./ajax/childrens_users.php",
		dataType: "xml",
		data: "type=costscenter&id=" + $("input#costcenter").val(),
		success: function(xml) {
			get_childrens_result_costscenter(xml);
		}

	});

}


// Receive childrens list and show
function get_childrens_result_costscenter(xml) {

	$('div#childrens_data').html('');

	$(xml).find('user').each(function() {

		var id_user = $(this).find('id').text();
		var name_user = $(this).find('name').text();

		$('div#childrens_data').append('<li><a href="#" OnClick="alter_or_ch_costscenter(' + id_user + ', 1)">' + name_user + '</a></li>');

	});

}

// Update Viewer
function update_state_costscenter() {
	get_orphans_costscenter();
	get_childrens_costscenter();
}


