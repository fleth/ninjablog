#!/bin/sh

# --- setup htaccess ---
echo "setup .htaccess "
script_dir=`dirname ${0}`
dir=`dirname $script_dir`
targets=`find $dir/ui -name "public_html"`

for target in $targets; do
	htaccess="$target/.htaccess"
	src="$script_dir/htaccess"
	cp $src $htaccess
	echo "please edit 'RewriteBase' in $htaccess"
done
echo "done"

# ----------------------
