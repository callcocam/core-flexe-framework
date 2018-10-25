<?php

namespace Flexe\Services\Seo\Traits;

use Flexe\Services\Seo\Contracts\SEOFriendly;

trait SEOTools
{
    /**
     * @return \Flexe\Services\Seo\Contracts\SEOTools
     */
    protected function seo()
    {
        return app('seotools');
    }

    /**
     * @param SEOFriendly $friendly
     *
     * @return \Flexe\Services\Seo\Contracts\SEOTools
     */
    protected function loadSEO(SEOFriendly $friendly)
    {
        $SEO = $this->seo();

        $friendly->loadSEO($SEO);

        return $SEO;
    }
}
