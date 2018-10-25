<?php

namespace Flexe\Services\Seo\Contracts;

interface SEOFriendly
{
    /**
     * Performs SEO settings.
     *
     * @param SEOTools $SEOTools
     */
    public function loadSEO(SEOTools $SEOTools);
}
