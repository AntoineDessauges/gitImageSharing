<?php


 /**
     * Create temporary URLs to your protected Amazon S3 files.
     *
     * @param string $key Your Amazon S3 access key
     * @param string $secret Your Amazon S3 secret key
     * @param string $bucket The bucket (bucket.s3.amazonaws.com)
     * @param string $path The target file path
     * @param int $expiry In minutes
     * @return string Temporary Amazon S3 URL
     * @see http://awsdocs.s3.amazonaws.com/S3/20060301/s3-dg-20060301.pdf
     */
    function getS3TemporaryUrl($key, $secret, $bucket, $path, $expiry = 30)
    {
        $expiry = time() + $expiry * 60;

        // Format the string to be signed
        $string = sprintf("GET\n\n\n%s\n/%s/%s", $expiry, $bucket, $path);

        // Generate an HMAC-SHA1 signature for it
        $signature = base64_encode(hash_hmac('sha1', $string, $secret, true));

        // Create the final URL
        return sprintf(
            "https://%s.s3.amazonaws.com/%s?%s",
            $bucket,
            $path,
            http_build_query([
                'AWSAccessKeyId' => $key,
                'Expires' => $expiry,
                'Signature' => $signature
            ])
        );
    }

    function getS3URL($path)
    {
      $key = "AKIAIKPSTUHIOXG6HJMA";
      $secret = "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";
      $bucket = "si-t1a.cpnv.ch";
      return getS3TemporaryUrl($key, $secret, $bucket, $path);  
    }

    // TODO Enter your AWS credentials
// Note: these can be set as environment variables (with the same name) or constants.
define('AWS_ACCESS_KEY', env('S3_KEY'));
define('AWS_SECRET', env('S3_SECRET'));

// TODO Enter your bucket and region details (see details below)
$s3FormDetails = getS3Details(env('S3_BUCKET'), 'eu-west-1');

/**
 * Get all the necessary details to directly upload a private file to S3
 * asynchronously with JavaScript using the Signature V4.
 *
 * @param string $s3Bucket your bucket's name on s3.
 * @param string $region   the bucket's location/region, see here for details: http://amzn.to/1FtPG6r
 * @param string $acl      the visibility/permissions of your file, see details: http://amzn.to/18s9Gv7
 *
 * @return array ['url', 'inputs'] the forms url to s3 and any inputs the form will need.
 */
function getS3Details($s3Bucket, $region, $acl = 'private') {

    // Options and Settings
    $awsKey = (!empty(getenv('AWS_ACCESS_KEY')) ? getenv('AWS_ACCESS_KEY') : AWS_ACCESS_KEY);
    $awsSecret = (!empty(getenv('AWS_SECRET')) ? getenv('AWS_SECRET') : AWS_SECRET);

    $algorithm = "AWS4-HMAC-SHA256";
    $service = "s3";
    $date = gmdate("Ymd\THis\Z");
    $shortDate = gmdate("Ymd");
    $requestType = "aws4_request";
    $expires = "86400"; // 24 Hours
    $successStatus = "201";
    $url = "//{$s3Bucket}.{$service}-{$region}.amazonaws.com";

    // Step 1: Generate the Scope
    $scope = [
        $awsKey,
        $shortDate,
        $region,
        $service,
        $requestType
    ];
    $credentials = implode('/', $scope);

    // Step 2: Making a Base64 Policy
    $policy = [
        'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+2 minutes')),
        'conditions' => [
            ['bucket' => $s3Bucket],
            ['acl' => $acl],
            ['starts-with', '$key', ''],
            ['starts-with', '$Content-Type', ''],
            ['success_action_status' => $successStatus],
            ['x-amz-credential' => $credentials],
            ['x-amz-algorithm' => $algorithm],
            ['x-amz-date' => $date],
            ['x-amz-expires' => $expires],
        ]
    ];
    $base64Policy = base64_encode(json_encode($policy));

    // Step 3: Signing your Request (Making a Signature)
    $dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
    $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
    $dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
    $signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);

    $signature = hash_hmac('sha256', $base64Policy, $signingKey);

    // Step 4: Build form inputs
    // This is the data that will get sent with the form to S3
    $inputs = [
        'Content-Type' => '',
        'acl' => $acl,
        'success_action_status' => $successStatus,
        'policy' => $base64Policy,
        'X-amz-credential' => $credentials,
        'X-amz-algorithm' => $algorithm,
        'X-amz-date' => $date,
        'X-amz-expires' => $expires,
        'X-amz-signature' => $signature
    ];

    return compact('url', 'inputs');
}
    