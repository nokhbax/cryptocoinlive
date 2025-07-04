/**
 * CryptoCoin Live Theme JavaScript
 * Main functionality for the theme
 * 
 * @package CryptoCoinLive
 * @version 1.0
 */

(function($) {
    'use strict';

    // Global variables
    let stream = null;
    let isAnalyzing = false;
    let lastScrollTop = 0;

    // Initialize when document is ready
    $(document).ready(function() {
        initializeTheme();
        initializeFloatingParticles();
        initializeScrollEffects();
        initializeImageAnalysis();
        initializeCameraFunctionality();
        initializeFormValidation();
        initializeAnimations();
        initializeAccessibility();
        initializePerformance();
    });

    /**
     * Initialize main theme functionality
     */
    function initializeTheme() {
        console.log('🚀 CryptoCoin Live Theme Initialized');
        
        // Smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                const headerHeight = $('.main-navigation').outerHeight() || 80;
                $('html, body').animate({
                    scrollTop: target.offset().top - headerHeight - 20
                }, 600, 'easeInOutCubic');
            }
        });

        // Close mobile menu when clicking menu links
        $('.main-menu a').on('click', function() {
            if (window.innerWidth <= 768) {
                closeMobileMenu();
            }
        });

        // Handle window resize
        $(window).on('resize', debounce(handleWindowResize, 250));
        
        // Initialize lazy loading for images
        initializeLazyLoading();
        
        // Initialize tooltips
        initializeTooltips();
    }

    /**
     * Create floating particles animation
     */
    function initializeFloatingParticles() {
        const particlesContainer = $('#particles');
        if (!particlesContainer.length) return;

        const particleCount = window.innerWidth > 768 ? 50 : 25;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = $('<div class="particle"></div>');
            particle.css({
                left: Math.random() * 100 + '%',
                animationDelay: Math.random() * 20 + 's',
                animationDuration: (15 + Math.random() * 10) + 's',
                width: (2 + Math.random() * 4) + 'px',
                height: (2 + Math.random() * 4) + 'px'
            });
            particlesContainer.append(particle);
        }
    }

    /**
     * Initialize scroll effects
     */
    function initializeScrollEffects() {
        const nav = $('.main-navigation');
        const backToTop = $('.back-to-top');

        $(window).on('scroll', throttle(function() {
            const currentScroll = $(window).scrollTop();
            
            // Navigation scroll effect
            if (nav.length) {
                if (currentScroll > 100) {
                    nav.css({
                        'background': 'rgba(10, 10, 10, 0.95)',
                        'padding': '0.5rem 2rem',
                        'backdrop-filter': 'blur(15px)'
                    });
                } else {
                    nav.css({
                        'background': 'rgba(10, 10, 10, 0.8)',
                        'padding': '1rem 2rem',
                        'backdrop-filter': 'blur(10px)'
                    });
                }

                // Hide/show navigation on scroll
                if (currentScroll > lastScrollTop && currentScroll > 200) {
                    nav.css('transform', 'translateY(-100%)');
                } else {
                    nav.css('transform', 'translateY(0)');
                }
            }

            // Back to top button
            if (backToTop.length) {
                if (currentScroll > 300) {
                    backToTop.addClass('visible');
                } else {
                    backToTop.removeClass('visible');
                }
            }

            lastScrollTop = currentScroll;
        }, 16));

        // Intersection Observer for animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $(entry.target).addClass('animate-in');
                    }
                });
            }, observerOptions);

            // Observe elements for animation
            $('.feature-card, .pricing-card, .post-card, .testimonial-card, .footer-section').each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(50px)',
                    'transition': `all 0.6s ease ${index * 0.1}s`
                });
                observer.observe(this);
            });
        }
    }

    /**
     * Initialize image analysis functionality
     */
    function initializeImageAnalysis() {
        const uploadArea = $('#uploadArea');
        const fileInput = $('#fileInput');
        const cameraInput = $('#cameraInput');
        const loading = $('#loading');

        if (!uploadArea.length) return;

        // Drag and drop functionality
        uploadArea.on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });

        uploadArea.on('dragleave', function() {
            $(this).removeClass('dragover');
        });

        uploadArea.on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                handleFileUpload(files[0]);
            }
        });

        // File input change
        fileInput.on('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0]);
            }
        });

        // Camera input change
        cameraInput.on('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0]);
            }
        });

        /**
         * Handle file upload and analysis
         */
        function handleFileUpload(file) {
            if (isAnalyzing) return;

            // Validate file type
            if (!file.type.startsWith('image/')) {
                showNotification(cryptocoin_ajax.strings?.invalid_file || 'Please upload an image file only', 'error');
                return;
            }

            // Validate file size (10MB)
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                showNotification(cryptocoin_ajax.strings?.file_too_large || 'File size is too large. Maximum 10MB allowed', 'error');
                return;
            }

            isAnalyzing = true;
            showLoading();
            removeExistingResults();

            const formData = new FormData();
            formData.append('image', file);
            formData.append('action', 'analyze_image');
            formData.append('nonce', cryptocoin_ajax.nonce);

            $.ajax({
                url: cryptocoin_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                timeout: 30000,
                success: function(response) {
                    if (response.success) {
                        displayResults(response.data);
                        showNotification(cryptocoin_ajax.strings?.analysis_complete || 'Analysis completed successfully!', 'success');
                    } else {
                        showNotification(response.data || cryptocoin_ajax.strings?.analysis_error || 'An error occurred during analysis', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = cryptocoin_ajax.strings?.connection_error || 'Connection error occurred';
                    
                    if (status === 'timeout') {
                        errorMessage = cryptocoin_ajax.strings?.timeout_error || 'Request timed out. Please try again.';
                    } else if (xhr.responseJSON && xhr.responseJSON.data) {
                        errorMessage = xhr.responseJSON.data;
                    }
                    
                    showNotification(errorMessage, 'error');
                    console.error('Analysis error:', error);
                },
                complete: function() {
                    isAnalyzing = false;
                    hideLoading();
                    resetFileInputs();
                }
            });
        }

        /**
         * Display analysis results
         */
        function displayResults(data) {
            if (!data || !data.results) {
                showNotification(cryptocoin_ajax.strings?.invalid_response || 'Invalid response from server', 'error');
                return;
            }

            const { bullish, bearish, sideways } = data.results;
            
            // Determine dominant trend
            let dominantTrend = 'bullish';
            let dominantColor = '#00ff88';
            let dominantIcon = '🚀';
            
            if (bearish > bullish && bearish > sideways) {
                dominantTrend = 'bearish';
                dominantColor = '#ff0055';
                dominantIcon = '📉';
            } else if (sideways > bullish && sideways > bearish) {
                dominantTrend = 'sideways';
                dominantColor = '#ffaa00';
                dominantIcon = '↔️';
            }

            const resultsHTML = `
                <div class="analysis-results" id="analysis-results">
                    <div class="results-header">
                        <div class="results-icon" style="color: ${dominantColor}; font-size: 3rem;">${dominantIcon}</div>
                        <h3>${cryptocoin_ajax.strings?.analysis_results || 'Analysis Results'}</h3>
                        <p class="dominant-trend" style="color: ${dominantColor};">
                            ${cryptocoin_ajax.strings?.dominant_trend || 'Dominant Trend'}: 
                            <strong>${getDominantTrendText(dominantTrend)}</strong>
                        </p>
                    </div>
                    
                    <div class="results-grid">
                        <div class="result-item bullish">
                            <div class="result-label">
                                <span class="result-icon">🚀</span>
                                <span>${cryptocoin_ajax.strings?.bullish_trend || 'Bullish Trend'}</span>
                            </div>
                            <div class="result-value">${bullish}%</div>
                            <div class="result-bar">
                                <div class="result-fill" style="width: ${bullish}%; background: linear-gradient(90deg, #00ff88, #00cc6a);"></div>
                            </div>
                        </div>
                        
                        <div class="result-item bearish">
                            <div class="result-label">
                                <span class="result-icon">📉</span>
                                <span>${cryptocoin_ajax.strings?.bearish_trend || 'Bearish Trend'}</span>
                            </div>
                            <div class="result-value">${bearish}%</div>
                            <div class="result-bar">
                                <div class="result-fill" style="width: ${bearish}%; background: linear-gradient(90deg, #ff0055, #cc0044);"></div>
                            </div>
                        </div>
                        
                        <div class="result-item sideways">
                            <div class="result-label">
                                <span class="result-icon">↔️</span>
                                <span>${cryptocoin_ajax.strings?.sideways_trend || 'Sideways Trend'}</span>
                            </div>
                            <div class="result-value">${sideways}%</div>
                            <div class="result-bar">
                                <div class="result-fill" style="width: ${sideways}%; background: linear-gradient(90deg, #ffaa00, #cc8800);"></div>
                            </div>
                        </div>
                    </div>
                    
                    ${data.recommendation ? `
                        <div class="recommendation">
                            <h4>${cryptocoin_ajax.strings?.recommendation || 'AI Recommendation'}</h4>
                            <p>${data.recommendation}</p>
                        </div>
                    ` : ''}
                    
                    ${data.analysis_id ? `
                        <div class="analysis-meta">
                            <span>${cryptocoin_ajax.strings?.analysis_id || 'Analysis ID'}: <strong>#${data.analysis_id}</strong></span>
                            <span>${cryptocoin_ajax.strings?.timestamp || 'Timestamp'}: <strong>${new Date().toLocaleString()}</strong></span>
                        </div>
                    ` : ''}
                    
                    <div class="results-actions">
                        <button class="btn-primary" onclick="cryptocoinLive.resetAnalysis()">
                            <span>🔄</span> ${cryptocoin_ajax.strings?.new_analysis || 'New Analysis'}
                        </button>
                        <button class="btn-secondary" onclick="cryptocoinLive.shareResults()">
                            <span>📤</span> ${cryptocoin_ajax.strings?.share_results || 'Share Results'}
                        </button>
                    </div>
                </div>
            `;

            // Insert results after upload section
            $('.upload-section').after(resultsHTML);
            
            // Animate results in
            setTimeout(() => {
                $('#analysis-results').addClass('results-visible');
                animateResultBars();
                scrollToResults();
            }, 100);
        }

        /**
         * Get dominant trend text
         */
        function getDominantTrendText(trend) {
            const trendTexts = {
                'bullish': cryptocoin_ajax.strings?.bullish || 'Bullish',
                'bearish': cryptocoin_ajax.strings?.bearish || 'Bearish',
                'sideways': cryptocoin_ajax.strings?.sideways || 'Sideways'
            };
            return trendTexts[trend] || trend;
        }

        /**
         * Animate result bars
         */
        function animateResultBars() {
            $('.result-fill').each(function(index) {
                const $this = $(this);
                const width = $this.css('width');
                $this.css('width', '0');
                setTimeout(() => {
                    $this.animate({ width: width }, 800, 'easeOutCubic');
                }, index * 200);
            });
        }

        /**
         * Scroll to results
         */
        function scrollToResults() {
            const results = $('#analysis-results');
            if (results.length) {
                const headerHeight = $('.main-navigation').outerHeight() || 80;
                $('html, body').animate({
                    scrollTop: results.offset().top - headerHeight - 20
                }, 600);
            }
        }

        /**
         * Show loading state
         */
        function showLoading() {
            uploadArea.hide();
            loading.addClass('show').show();
        }

        /**
         * Hide loading state
         */
        function hideLoading() {
            loading.removeClass('show').hide();
            uploadArea.show();
        }

        /**
         * Remove existing results
         */
        function removeExistingResults() {
            $('.analysis-results').remove();
        }

        /**
         * Reset file inputs
         */
        function resetFileInputs() {
            fileInput.val('');
            cameraInput.val('');
        }
    }

    /**
     * Initialize camera functionality
     */
    function initializeCameraFunctionality() {
        const video = document.getElementById('videoElement');
        const canvas = document.getElementById('canvas');
        const cameraPreview = $('#cameraPreview');

        // Open camera function
        window.openCamera = function() {
            if (isAnalyzing) return;

            // Check if it's a mobile device
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                // Use native camera input on mobile
                $('#cameraInput').click();
                return;
            }

            // Use getUserMedia for desktop
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showNotification(cryptocoin_ajax.strings?.camera_not_supported || 'Camera is not supported in this browser', 'error');
                $('#cameraInput').click(); // Fallback
                return;
            }

            cameraPreview.show();

            const constraints = {
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'environment'
                }
            };

            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(mediaStream) {
                    stream = mediaStream;
                    if (video) {
                        video.srcObject = stream;
                        video.play().catch(console.error);
                    }
                })
                .catch(function(error) {
                    console.error('Camera error:', error);
                    closeCamera();
                    showNotification(cryptocoin_ajax.strings?.camera_error || 'Could not access camera', 'error');
                    $('#cameraInput').click(); // Fallback
                });
        };

        // Capture photo function
        window.capturePhoto = function() {
            if (!video || !canvas || !video.videoWidth) {
                showNotification(cryptocoin_ajax.strings?.camera_not_ready || 'Camera is not ready yet', 'error');
                return;
            }

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            canvas.toBlob(function(blob) {
                if (blob) {
                    const file = new File([blob], 'camera-capture.jpg', { type: 'image/jpeg' });
                    handleFileUpload(file);
                    closeCamera();
                } else {
                    showNotification(cryptocoin_ajax.strings?.capture_failed || 'Failed to capture photo', 'error');
                }
            }, 'image/jpeg', 0.8);
        };

        // Close camera function
        window.closeCamera = function() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            if (video) video.srcObject = null;
            cameraPreview.hide();
        };

        // Handle escape key to close camera
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && cameraPreview.is(':visible')) {
                closeCamera();
            }
        });
    }

    /**
     * Initialize form validation
     */
    function initializeFormValidation() {
        // Newsletter form
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.loading-spinner');
            const $text = $submitBtn.find('span:first-child');
            const email = $form.find('input[name="newsletter_email"]').val();

            // Validate email
            if (!isValidEmail(email)) {
                showNotification(cryptocoin_ajax.strings?.invalid_email || 'Please enter a valid email address', 'error');
                return;
            }

            // Show loading state
            $spinner.show();
            $text.hide();
            $submitBtn.prop('disabled', true);

            $.ajax({
                url: cryptocoin_ajax.ajax_url,
                type: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    if (response.success) {
                        showNotification(cryptocoin_ajax.strings?.newsletter_success || 'Successfully subscribed to newsletter!', 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data || cryptocoin_ajax.strings?.newsletter_error || 'An error occurred. Please try again.', 'error');
                    }
                },
                error: function() {
                    showNotification(cryptocoin_ajax.strings?.connection_error || 'Connection error occurred', 'error');
                },
                complete: function() {
                    $spinner.hide();
                    $text.show();
                    $submitBtn.prop('disabled', false);
                }
            });
        });

        // Contact forms
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            let isValid = true;

            // Validate required fields
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (!value) {
                    $field.addClass('error');
                    isValid = false;
                } else {
                    $field.removeClass('error');
                }

                // Validate email fields
                if ($field.attr('type') === 'email' && value && !isValidEmail(value)) {
                    $field.addClass('error');
                    isValid = false;
                }
            });

            if (!isValid) {
                showNotification(cryptocoin_ajax.strings?.form_validation_error || 'Please fill in all required fields correctly', 'error');
                return;
            }

            // Submit form via AJAX
            const $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text(cryptocoin_ajax.loading_text || 'Sending...');

            $.ajax({
                url: cryptocoin_ajax.ajax_url,
                type: 'POST',
                data: $form.serialize() + '&action=contact_form_submit',
                success: function(response) {
                    if (response.success) {
                        showNotification(cryptocoin_ajax.strings?.contact_success || 'Message sent successfully!', 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data || cryptocoin_ajax.strings?.contact_error || 'Failed to send message', 'error');
                    }
                },
                error: function() {
                    showNotification(cryptocoin_ajax.strings?.connection_error || 'Connection error occurred', 'error');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).text(cryptocoin_ajax.strings?.send_message || 'Send Message');
                }
            });
        });
    }

    /**
     * Initialize animations
     */
    function initializeAnimations() {
        // Add animate-in class styles
        $('<style>').prop('type', 'text/css').html(`
            .animate-in {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
            
            .results-visible {
                opacity: 1;
                transform: translateY(0);
                animation: slideInUp 0.6s ease-out;
            }
            
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .result-fill {
                transition: width 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }
            
            .analysis-results {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease-out;
            }
        `).appendTo('head');

        // Stagger animations for feature cards
        $('.feature-card').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });

        // Hover effects for interactive elements
        $('.btn-primary, .btn-secondary').hover(
            function() {
                $(this).css('transform', 'translateY(-2px)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );
    }

    /**
     * Initialize accessibility features
     */
    function initializeAccessibility() {
        // Add skip links
        if (!$('.skip-link').length) {
            $('body').prepend(`
                <a class="skip-link screen-reader-text" href="#main">
                    ${cryptocoin_ajax.strings?.skip_to_content || 'Skip to content'}
                </a>
            `);
        }

        // Enhance keyboard navigation
        $('.main-menu a, .btn-primary, .btn-secondary').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });

        // Focus management for mobile menu
        $('.mobile-menu-toggle').on('click', function() {
            setTimeout(() => {
                if ($('.main-menu').hasClass('active')) {
                    $('.main-menu a:first').focus();
                }
            }, 100);
        });

        // ARIA attributes for dynamic content
        $('.upload-area').attr({
            'role': 'button',
            'tabindex': '0',
            'aria-label': cryptocoin_ajax.strings?.upload_area_label || 'Upload image for analysis'
        });

        // Announce important changes to screen readers
        function announceToScreenReader(message) {
            const announcement = $('<div>', {
                'aria-live': 'polite',
                'aria-atomic': 'true',
                'class': 'sr-only',
                'text': message
            });
            
            $('body').append(announcement);
            setTimeout(() => announcement.remove(), 1000);
        }

        // Use this for important notifications
        window.announceToScreenReader = announceToScreenReader;
    }

    /**
     * Initialize performance optimizations
     */
    function initializePerformance() {
        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Preload critical resources
        const criticalResources = [
            '/wp-content/themes/cryptocoin-live/assets/css/animations.css',
            '/wp-content/themes/cryptocoin-live/assets/fonts/cairo.woff2'
        ];

        criticalResources.forEach(resource => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = resource;
            link.as = resource.includes('.css') ? 'style' : 'font';
            if (link.as === 'font') {
                link.type = 'font/woff2';
                link.crossOrigin = 'anonymous';
            }
            document.head.appendChild(link);
        });

        // Optimize scroll performance
        let ticking = false;
        
        function updateScrollEffects() {
            // Your scroll effects here
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(updateScrollEffects);
                ticking = true;
            }
        });
    }

    /**
     * Initialize lazy loading
     */
    function initializeLazyLoading() {
        $('img').each(function() {
            const $img = $(this);
            if (!$img.attr('loading')) {
                $img.attr('loading', 'lazy');
            }
        });
    }

    /**
     * Initialize tooltips
     */
    function initializeTooltips() {
        $('[title]').each(function() {
            const $element = $(this);
            const title = $element.attr('title');
            
            $element.removeAttr('title').hover(
                function(e) {
                    const tooltip = $('<div class="tooltip">' + title + '</div>');
                    $('body').append(tooltip);
                    
                    const x = e.pageX + 10;
                    const y = e.pageY - 30;
                    
                    tooltip.css({
                        position: 'absolute',
                        left: x,
                        top: y,
                        background: '#333',
                        color: '#fff',
                        padding: '5px 10px',
                        borderRadius: '4px',
                        fontSize: '12px',
                        zIndex: 10000,
                        whiteSpace: 'nowrap'
                    });
                },
                function() {
                    $('.tooltip').remove();
                }
            );
        });
    }

    /**
     * Utility functions
     */
    
    // Debounce function
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Throttle function
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Email validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Handle window resize
    function handleWindowResize() {
        // Close mobile menu on desktop
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
        
        // Reinitialize particles if needed
        if (window.innerWidth !== window.lastWidth) {
            $('#particles').empty();
            initializeFloatingParticles();
            window.lastWidth = window.innerWidth;
        }
    }

    // Close mobile menu
    function closeMobileMenu() {
        $('.main-menu').removeClass('active');
        $('.mobile-menu-toggle').attr('aria-expanded', 'false');
        $('.mobile-menu-toggle .menu-icon').text('☰');
    }

    // Show notification
    function showNotification(message, type = 'info', duration = 5000) {
        const notification = $(`
            <div class="notification notification-${type}">
                <span>${message}</span>
                <button onclick="$(this).parent().remove()">×</button>
            </div>
        `);

        $('body').append(notification);

        // Auto remove
        setTimeout(() => {
            notification.fadeOut(() => notification.remove());
        }, duration);

        // Announce to screen readers
        if (window.announceToScreenReader) {
            window.announceToScreenReader(message);
        }
    }

    // Global object for external access
    window.cryptocoinLive = {
        resetAnalysis: function() {
            $('.analysis-results').fadeOut(() => {
                $('.analysis-results').remove();
                $('#fileInput, #cameraInput').val('');
                $('html, body').animate({
                    scrollTop: $('.upload-section').offset().top - 100
                }, 600);
            });
        },
        
        shareResults: function() {
            const results = $('.analysis-results');
            if (!results.length) return;

            const bullish = results.find('.result-item.bullish .result-value').text();
            const bearish = results.find('.result-item.bearish .result-value').text();
            const sideways = results.find('.result-item.sideways .result-value').text();

            const shareText = `🎯 ${cryptocoin_ajax.strings?.crypto_analysis || 'Cryptocurrency Analysis'} - CryptoCoin Live

🚀 ${cryptocoin_ajax.strings?.bullish_trend || 'Bullish'}: ${bullish}
📉 ${cryptocoin_ajax.strings?.bearish_trend || 'Bearish'}: ${bearish}
↔️ ${cryptocoin_ajax.strings?.sideways_trend || 'Sideways'}: ${sideways}

${cryptocoin_ajax.strings?.powered_by_ai || 'Powered by AI'}
🌐 ${window.location.origin}`;

            if (navigator.share) {
                navigator.share({
                    title: cryptocoin_ajax.strings?.crypto_analysis || 'Cryptocurrency Analysis',
                    text: shareText
                }).catch(console.error);
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(shareText).then(() => {
                    showNotification(cryptocoin_ajax.strings?.copied_to_clipboard || 'Results copied to clipboard!', 'success');
                }).catch(() => {
                    alert(shareText);
                });
            } else {
                alert(shareText);
            }
        },
        
        showNotification: showNotification
    };

    // Add custom easing
    $.easing.easeInOutCubic = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

    $.easing.easeOutCubic = function(x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b;
    };

})(jQuery);