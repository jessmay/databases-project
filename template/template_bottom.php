				</div>
				<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<h3><span class="glyphicon glyphicon-search" style="padding-right:8px;vertical-align:top"></span>Search</h3>
						<ul class="nav nav-pills nav-stacked">
                            <li role="presentation"><a href="/university"><span class="glyphicon glyphicon-education" style="padding-right:8px"></span>University</a></li>
							<li role="presentation"><a href="/rso"><span class="glyphicon glyphicon-blackboard" style="padding-right:8px"></span>RSO</a></li>
                            <li role="presentation"><a href="/event"><span class="glyphicon glyphicon-calendar" style="padding-right:8px"></span>Event</a></li>
						</ul>
                        <?php
                            if ($logged_in):
                        ?>
						<h3><span class="glyphicon glyphicon-pencil" style="padding-right:8px;vertical-align:top"></span>Create</h3>
						<ul class="nav nav-pills nav-stacked">
							<li role="presentation"><a href="/university/create"><span class="glyphicon glyphicon-education" style="padding-right:8px"></span>University</a></li>
                            <li role="presentation"><a href="/rso/create"><span class="glyphicon glyphicon-blackboard" style="padding-right:8px"></span>RSO</a></li>
                            <?php
                                if ($is_type_super_admin || $is_type_admin):
                            ?>
							<li role="presentation"><a href="/event/create"><span class="glyphicon glyphicon-calendar" style="padding-right:8px"></span>Event</a></li>
                            <?php
                                endif;
                            ?>
						</ul>
                        <?php
                            endif;
                        ?>
					</div>
				</div>
			</div>
			<hr>
			<footer>
				<p>
					&copy; <?=date('Y')?> Group 31 - Nigel Carter, Cindy Harn, Hector Hernandez, Jessica May
				</p>
			</footer>
		</div>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</body>
</html>
