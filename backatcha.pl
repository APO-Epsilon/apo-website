#!/usr/bin/perl
use warnings;
use strict;
use CGI qw(:standard);
 
# Path to files to open:
#my $header_file = '';    # Path to Header
#my $footer_file = '/full/path/to/footer_file';    # Path to Footer
#my $content_dir = '#'; # Path to Web Pages
my $index_file = 'index.php';
my $layout_file = 'layout.php';
 
# List of file extensions that are safe to open:
my @safe_files_ext = qw(
        html
    	php
    	css
);
 
# Get page to open (user specified):
my $query       = new CGI;
chomp(my $page  = $query->param('page') || '');
 
# Get rid of white space on file names passed, if any:
$page =~ s/\s+//g if ($page ne "");
 
# Print header (for CGI):
print header();

#print("Hello World"."H");
 
# Static file (0) or user specified (1):
read_file(0, $index_file);
read_file(0, $layout_file);
#read_file(1, $content_dir . '/' . $page) if ($page ne "");
#read_file(0, $footer_file);
#read_file($index_file);
 
# Display file, if safe:
sub read_file {
        my ($in_page, $file) = @_;
        if ($in_page) { # If file is user specified.
                error("Invalid syntax") if ($file =~ /\.\./); # Disallow dir traversing.
                foreach my $file_ext (@safe_files_ext) { # Check each valid file extension:
                        # Stop and report error if in valid.
                        error("Invalid syntax for $file") if ($file !~ /\.$file_ext$/i);
                }
        }
        # Open and print file contents if we're okay.
        open(FILE, $file)       or error("Can't open $file $!");  # report error if can't open file.
                # Do more stuff here if you want.
                print while (<FILE>); # Print file line by line for best efficiency.
        close(FILE);
}
 
# Error subroutine to display error and exit.
sub error {
        my $reason = shift;
        print "Error: $reason\n";
        exit;
}