
(add-to-list 'load-path "~/.emacs.d/elpa/w3m")
(setq w3m-coding-system 'utf-8
      w3m-file-coding-system 'utf-8
      w3m-file-name-coding-system 'utf-8
      w3m-input-coding-system 'utf-8
      w3m-output-coding-system 'utf-8
      w3m-terminal-coding-system 'utf-8)
(setq w3m-use-cookies t)
(setq w3m-cookie-accept-bad-cookies t)
(setq w3m-home-page
      (if (file-readable-p "~/html/home.html")
        (concat "file://" (expand-file-name "~/html/home.html"))
        "https://www.google.com.hk"))

(setq w3m-use-toolbar t
      ;w3m-use-tab     nil
      w3m-key-binding 'info)

;; show images in the browser
;(setq w3m-default-display-inline-images t)

;;(setq w3m-search-default-engine "g")
(setq w3m-search-default-engine "baidu")
(eval-after-load "w3m-search" '(progn
                                 ; C-u S g RET <search term> RET
					;(add-to-list 'w3m-search-engine-alist '("g" "http://www.google.com.hk/search?hl=en&q=%s" utf-8))
				 (add-to-list 'w3m-search-engine-alist '("baidu" "http://www.baidu.com/baidu?wd=%s" utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("wz" "http://zh.wikipedia.org/wiki/Special:Search?search=%s" utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("q" "http://www.google.com.hk/search?hl=en&q=%s+site:stackoverflow.com" utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("s" "http://code.ohloh.net/search?s=%s&browser=Default"  utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("b" "http://blogsearch.google.com.hk/blogsearch?q=%s" utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("w" "http://en.wikipedia.org/wiki/Special:Search?search=%s" utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("d" "http://dictionary.reference.com/search?q=%s" utf-8))
                                 (add-to-list 'w3m-search-engine-alist '("j" "http://www.google.com.hk/search?ie=UTF-8&oe=UTF-8&sourceid=navclient&btnI=1&q=%s+site:developer.mozilla.org" utf-8))
                                 ))

(setq w3m-command-arguments       '("-F" "-cookie")
      w3m-mailto-url-function     'compose-mail
      browse-url-browser-function 'w3m
      mm-text-html-renderer       'w3m)

(defun w3m-mode-hook-setup ()
  (w3m-lnum-mode 1))

(add-hook 'w3m-mode-hook 'w3m-mode-hook-setup)

; external browser
(setq browse-url-generic-program
      (cond
       (*is-a-mac* "open")
       (*linux* (executable-find "firefox"))
       ))

(setq browse-url-browser-function 'browse-url-generic)

;; use external browser to search programming stuff
(defun w3mext-hacker-search ()
  "search word under cursor in google code search and stackoverflow.com"
  (interactive)
  (require 'w3m)
  (let ((keyword (w3m-url-encode-string (thing-at-point 'symbol))))
    ;; google
    (browse-url-generic (concat "http://www.google.com.au/search?hl=en&q=%22"
                                keyword
                                "%22"
                                (if buffer-file-name
									(concat "+filetype%3A" (file-name-extension buffer-file-name))
									"")  ))
    (browse-url-generic (concat "http://www.google.com.hk/search?hl=en&q="
                                keyword
                                "+site:stackoverflow.com" ))
    ;; koders.com
    (browse-url-generic (concat "http://code.ohloh.net/search?s=\""
                                keyword
                                "\"&browser=Default&mp=1&ml=1&me=1&md=1&filterChecked=true" ))
    ))

(defun w3mext-open-link-or-image-or-url ()
  "Opens the current link or image or current page's uri or any url-like text under cursor in firefox."
  (interactive)
  (let (url)
    (if (or (string= major-mode "w3m-mode") (string= major-mode "gnus-article-mode"))
        (setq url (or (w3m-anchor) (w3m-image) w3m-current-url)))
    (browse-url-generic (if url url (car (browse-url-interactive-arg "URL: "))))
    ))
(global-set-key (kbd "C-c b") 'w3mext-open-link-or-image-or-url)

(defun w3mext-search-js-api-mdn ()
  "search current symbol under cursor in Mozilla Developer Network (MDN)"
  (interactive)
  (let ((keyword (thing-at-point 'symbol)))
    (w3m-search "j" keyword)
    ))

(add-hook 'prog-mode-hook '( lambda () (local-set-key (kbd "C-c ; h") 'w3mext-hacker-search)))




;;(require 'w3m-load)
;;(require 'mime-w3m)

;; ;;w3m proxy
;; (setq w3m-command-arguments
;;      (nconc w3m-command-arguments
;; 	     '("-o" "http_proxy=127.0.0.1:8087/"
;; 	       )
;; 	     ))

;;(setq url-proxy-services '(
;;			   ("http"."http://192.168.1.105:8086/proxy.pac")
;;			   ("http"."http://192.168.1.105:8086/proxy.pac")
;;			   ))
;;(setq w3m-no-proxy-domains '("local.com" "neighbor.com"))  

;; 使用cookies
(setq w3m-command-arguments '("-cookie" "-F"))
(setq w3m-use-cookies t)
(setq browse-url-browser-function 'w3m-browse-url)
(setq w3m-view-this-url-new-session-in-background t)

;; 默认显示图片
(setq w3m-default-display-inline-images t)
;;(setq w3m-default-toggle-inline-images t)

(add-hook 'w3m-mode-hook
	  (lambda()
	  (define-key w3m-mode-map (kbd "j") 'w3m-previous-buffer)
	  (define-key w3m-mode-map (kbd "k") 'w3m-next-buffer)
	  ))


(provide 'init-emacs-w3m)
