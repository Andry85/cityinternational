<?php

// This array maps URL template strings to either functions or absolute paths
// to include files.

// URL template strings are like: "/foo/bar/:my_variable"

// You can specify optional variables, e.g. "/foo/:my_optional_var?"

// Note that query strings are ignored.

// Functions must accept one array argument containing the URL args.
// This array will map variable names (as specified in the URL template string)
// to the values extracted from the request URL.

// If a function returns an array, it will be outputted as JSON with the
// appropriate HTTP headers.

// If a function returns boolean false (not just a falsy non-boolean), then
// the route is cancelled and load continues as normal. This allows you to
// check URL arguments and reject the route if a value is invalid.

// Include file paths must be absolute.

namespace IllicitWeb;

return [
	
];
