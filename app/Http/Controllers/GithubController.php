<?php

namespace App\Http\Controllers;

class GithubController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function api() {
        return response()->json(
            [
                'compare_url' => "http://nwt.upcor.se/public/compare/{owner1}/{repo1}/{owner2}/{repo2}"
            ]);
    }

    public function compare($owner1, $repo1, $owner2, $repo2) {
        $github_url = "https://api.github.com/";

        // fetch the first repository
        $repo1_url = $repo2_url = $repository_url = self::get($github_url)->repository_url;
        $repo1_url = str_replace("{owner}", $owner1, $repo1_url);
        $repo1_url = str_replace("{repo}", $repo1, $repo1_url);
        $repo1_obj = self::get($repo1_url);
        $pulls1_url = $repo1_obj->pulls_url;
        $pulls1_url = str_replace("{/number}", "", $pulls1_url);
        $pulls1_obj = self::get($pulls1_url);
        $pulls1_count = self::count_pulls($pulls1_obj);

        // fetch the second repository
        $repo2_url = str_replace("{owner}", $owner2, $repo2_url);
        $repo2_url = str_replace("{repo}", $repo2, $repo2_url);
        $repo2_obj = self::get($repo2_url);
        $pulls2_url = $repo2_obj->pulls_url;
        $pulls2_url = str_replace("{/number}", "", $pulls2_url);
        $pulls2_obj = self::get($pulls2_url);
        $pulls2_count = self::count_pulls($pulls2_obj);

        // compare the two
        $now = new \DateTime();
        $repo1_popularity = $repo1_obj->stargazers_count + $repo1_obj->subscribers_count;
        $repo1_pushed = \DateTime::createFromFormat(\DateTime::ISO8601, $repo1_obj->pushed_at);
        $repo1_activity = 1 / ((float)$repo1_pushed->diff($now)->format('%r%a') + 1);
        $repo1_activity_str = round(100 * $repo1_activity) . "%";
        $repo1_size = $repo1_obj->size;
        $repo2_popularity = $repo2_obj->stargazers_count + $repo2_obj->subscribers_count;
        $repo2_pushed = \DateTime::createFromFormat(\DateTime::ISO8601, $repo2_obj->pushed_at);
        $repo2_activity = 1 / ((float)$repo2_pushed->diff($now)->format('%r%a') + 1);
        $repo2_activity_str = round(100 * $repo2_activity) . "%";
        $repo2_size = $repo2_obj->size;
        $cmp_popularity = $repo1_popularity;
        if($cmp_popularity == 0)
            $cmp_popularity = 1;
        $diff_popularity = round(100 * $repo2_popularity / $cmp_popularity) . "%";
        $cmp_activity = $repo1_activity;
        if($cmp_activity == 0)
            $cmp_activity = 1;
        $diff_activity = round(100 * $repo2_activity / $cmp_activity) . "%";
        $cmp_size = $repo1_size;
        if($cmp_size == 0)
            $cmp_size = 1;
        $diff_size = round(100 * $repo2_size / $cmp_size) . "%";
        
        return response()->json(
            [
                'repo1' => [
                    'full_name' => $repo1_obj->full_name, 
                    'forks_count' => $repo1_obj->forks_count,
                    'stargazers_count' => $repo1_obj->stargazers_count,
                    'watchers_count' => $repo1_obj->watchers_count,
                    'subscribers_count' => $repo1_obj->subscribers_count,
                    'pushed_at' => $repo1_pushed->format('Y-m-d H:i'),
                    'open_pulls' => $pulls1_count->open_pulls,
                    'closed_pulls' => $pulls1_count->closed_pulls
                ],
                'repo2' => [
                    'full_name' => $repo2_obj->full_name, 
                    'forks_count' => $repo2_obj->forks_count,
                    'stargazers_count' => $repo2_obj->stargazers_count,
                    'watchers_count' => $repo2_obj->watchers_count,
                    'subscribers_count' => $repo2_obj->subscribers_count,
                    'pushed_at' => $repo2_pushed->format('Y-m-d H:i'),
                    'open_pulls' => $pulls2_count->open_pulls,
                    'closed_pulls' => $pulls2_count->closed_pulls
                ],
                'comparison' => [
                    'repo1_popularity' => $repo1_popularity,
                    'repo1_activity' => $repo1_activity_str,
                    'repo1_size' => $repo1_size,
                    'repo2_popularity' => $repo2_popularity,
                    'repo2_activity' => $repo2_activity_str,
                    'repo2_size' => $repo2_size,
                    'diff_popularity' => $diff_popularity,
                    'diff_activity' => $diff_activity,
                    'diff_size' => $diff_size
                ]
            ], 200);
    }

    private function count_pulls($pulls_obj) {
        $res = new \stdClass();
        $res->open_pulls = 0;
        $res->closed_pulls = 0;

        foreach($pulls_obj as $i => $pull) {
            if($pull->state == "open") {
                $res->open_pulls++;
            }
            if($pull->state == "close") {
                $res->closed_pulls++;
            }
        }

        return $res;
    }

    private function get($url) {
        $cc = curl_init();
        curl_setopt($cc, CURLOPT_URL, $url);
        curl_setopt($cc, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($cc, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($cc, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cc, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cc, CURLOPT_FOLLOWLOCATION, 1);
        return json_decode(curl_exec($cc));
    }
}
