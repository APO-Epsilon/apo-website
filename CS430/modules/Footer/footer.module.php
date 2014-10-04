<?php

class Footer { 
	
	private $foot;
		
	function index()
		{	
			$this->foot = '
				</body>
					<!-- Le javascript
				    ================================================== -->
				    <!-- Placed at the end of the document so the pages load faster -->
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/jquery.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-transition.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-alert.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-modal.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-dropdown.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-scrollspy.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-tab.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-tooltip.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-popover.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-button.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-collapse.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-carousel.js"></script>
				    <script src="http://apo.truman.edu/CS430/includes/bootstrap/js/bootstrap-typeahead.js"></script>
			    </body>
			</html>';	
			print $this->foot;
		}
	
}










