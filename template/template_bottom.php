				</div>
				<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<h3>RSOs</h3>
						<ul class="nav nav-pills nav-stacked">
							<li role="presentation"><a href="/rso">Find RSO</a></li>
							<li role="presentation"><a href="/rso/create">Create RSO</a></li>
						</ul>				
						<h3>Universities</h3>
						<ul class="nav nav-pills nav-stacked">
							<li role="presentation"><a href="/university">Find University</a></li>
							<li role="presentation"><a href="/university/create">Create University</a></li>
						</ul>
						<h3>Events</h3>
						<ul class="nav nav-pills nav-stacked">
							<li role="presentation"><a href="/event">Find Event</a></li>
                            <?php
                                if ($is_type_super_admin || $is_type_admin):
                            ?>
							<li role="presentation"><a href="/event/create">Create Event</a></li>
                            <?php
                                endif;
                            ?>
                        </ul>
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
