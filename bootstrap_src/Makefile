BOOTSTRAP_LESS = ./less/bootstrap.less
BOOTSTRAP_RESPONSIVE_LESS = ./less/responsive.less
DATE=$(shell date +%I:%M%p)
CHECK=\033[32m✔\033[39m
HR=\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#

#
# BUILD SIMPLE BOOTSTRAP DIRECTORY
# recess & uglifyjs are required
#

bootstrap:
	mkdir -p ../bootstrap/img
	mkdir -p ../bootstrap/css
	mkdir -p ../bootstrap/js
	cp img/* ../bootstrap/img/
	recess --compile ${BOOTSTRAP_LESS} > ../bootstrap/css/bootstrap.css
	cat js/bootstrap-transition.js js/bootstrap-alert.js js/bootstrap-button.js js/bootstrap-carousel.js js/bootstrap-collapse.js js/bootstrap-dropdown.js js/bootstrap-modal.js js/bootstrap-tooltip.js js/bootstrap-popover.js js/bootstrap-scrollspy.js js/bootstrap-tab.js js/bootstrap-typeahead.js > ../bootstrap/js/bootstrap.js


bootstrap-full:
	mkdir -p ../bootstrap/img
	mkdir -p ../bootstrap/css
	mkdir -p ../bootstrap/js
	cp img/* ../bootstrap/img/
	recess --compile ${BOOTSTRAP_LESS} > ../bootstrap/css/bootstrap.css
	recess --compress ${BOOTSTRAP_LESS} > ../bootstrap/css/bootstrap.min.css
	recess --compile ${BOOTSTRAP_RESPONSIVE_LESS} > ../bootstrap/css/bootstrap-responsive.css
	recess --compress ${BOOTSTRAP_RESPONSIVE_LESS} > ../bootstrap/css/bootstrap-responsive.min.css
	cat js/bootstrap-transition.js js/bootstrap-alert.js js/bootstrap-button.js js/bootstrap-carousel.js js/bootstrap-collapse.js js/bootstrap-dropdown.js js/bootstrap-modal.js js/bootstrap-tooltip.js js/bootstrap-popover.js js/bootstrap-scrollspy.js js/bootstrap-tab.js js/bootstrap-typeahead.js > ../bootstrap/js/bootstrap.js
	uglifyjs -nc ../bootstrap/js/bootstrap.js > ../bootstrap/js/bootstrap.min.js


#
# WATCH LESS FILES
#

watch:
	echo "Watching less files..."; \
	watchr -e "watch('less/.*\.less') { system 'make' }"


.PHONY: docs watch gh-pages