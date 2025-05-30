<?php

class View {
    private string $lastError = "";

    public function getLastError() : string {
        return $this->lastError;
    }

    public function getHeaderSite( string $faIcon, string $title ) : string {
        $html = "";

        $html .= '<div class="row mb-5 pb-4 align-items-center border-bottom" style="border-color: var(--macos-border) !important;">
            <div class="col-12 col-md-8">
                <a href="/" class="d-inline-block transition-transform" style="transition: transform 0.3s ease;">
                    <img src="/img/jellycloud-logo.svg" alt="JellyCloud" class="img-fluid" style="max-width: 280px; height: auto;">
                </a>
            </div>
            <div class="text-end col-12 col-md-4" id="divTitle">
                <div class="d-flex align-items-center justify-content-end">
                    <i class="fas '. $faIcon . ' me-2 text-jellyfin" style="font-size: 1.2rem;"></i>
                    <span class="fw-medium text-macos-secondary" style="font-size: 1.1rem;">'. $title .'</span>
                </div>
            </div>
        </div>';

        return $html;
    }
}