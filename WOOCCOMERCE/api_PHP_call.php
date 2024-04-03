////////////
/// APIs ///
////////////

add_action('rest_api_init', function () {
    // Register the route for updating settings
    register_rest_route('4d/v1', '/update_komunikator_params', array(
        'methods' => 'POST',
        'callback' => 'update_komunikator_params',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },

               //samo primjer
               'headers' =>  array(
                'autorizacija' => 'autorizacija',
                'Accept'        => 'application/json;ver=1.0',
                'Content-Type'  => 'application/json; charset=UTF-8'
            ),
    ));

    // Register the route for retrieving settingsl
    register_rest_route('4d/v1', '/get_komunikator_params', array(
        'methods' => 'GET',
        'callback' => 'get_komunikator_params',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },

               //samo primjer
               'headers' =>  array(
                'autorizacija' => 'autorizacija',
                'Accept'        => 'application/json;ver=1.0',
                'Content-Type'  => 'application/json; charset=UTF-8'
            ),
    ));

    // TODO: Later add permission_callback
    register_rest_route('4d/v1', '/clear-all-memcache', array(
        'methods' => 'GET',
        'callback' => 'clear_all_memcache',

             //samo primjer
             'headers' =>  array(
                'autorizacija' => 'autorizacija',
                'Accept'        => 'application/json;ver=1.0',
                'Content-Type'  => 'application/json; charset=UTF-8'
            ),
    ));
});

// Function to get and save the plugin options
function update_komunikator_params($request)
{
    // Get the JSON payload
    $params = $request->get_json_params();

    // Add the current Unix timestamp to the params array
    $params['unix_timestamp'] = time();

    // Assuming you want to save the entire JSON as an array in a single option
    // If your data is more complex, you may need to process it accordingly before saving
    $result = update_option('4d_komunikator_params', $params);

    if ($result) {
        return new WP_REST_Response(array('success' => true, 'message' => 'Options updated successfully'), 200);
    } else {
        return new WP_REST_Response(array('success' => false, 'message' => 'Failed to update options'), 500);
    }
}

// Function to get and return the plugin options
function get_komunikator_params()
{
    // Retrieve the option
    $options = get_option('4d_komunikator_params', []);

    $options['last_updated_time'] = date('Y-m-d H:i:s', $options['unix_timestamp']);

    // Check if the option exists and is not empty
    if (!empty($options)) {
        return new WP_REST_Response(array('success' => true, 'data' => $options), 200);
    } else {
        // Return a default response or error if no options are set
        return new WP_REST_Response(array('success' => false, 'message' => 'No options found'), 404);
    }
}

// Function to clear all memcache
function clear_all_memcache()
{
    global $memcached;

    $result = $memcached->flush();
    if ($result) {
        return new WP_REST_Response(array('success' => true, 'message' => 'Cleared cache successfully'), 200);
    } else {
        return new WP_REST_Response(array('success' => false, 'message' => 'Failed to clear all cache'), 500);
    }
}