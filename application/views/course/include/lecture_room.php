<?php if (!empty($lectureRooms)): ?>
<?php foreach ($lectureRooms as $lecture_room): ?>
	<div class="panel panel-info">
        <div class="panel-heading clearfix">
            <span class="panel-title"><?php echo strtoupper($lecture_room->room_code) ?></span>
            <small class="pull-right">Available Time Percentage: 30%</small>
        </div>
        <div class="panel-body p-t-10 p-l-10 p-r-10 p-b-10">
        	<div class="roomCalendar" id="<?php echo $lecture_room->room_code?>"></div>
        </div>
        <div class="panel-footer clearfix">
        	<small class="pull-right">Total Unit Plotted: 27</small>
        </div>
    </div>
<?php endforeach ?>
<?php endif ?>