;; -*- coding: utf-8 -*-
;;目录下的文件el 全部编译成elc
;;(byte-recompile-directory (expand-file-name "~/.emacs.d") 0)
(setq emacs-load-start-time (current-time))

;; init-plugins
(add-to-list 'load-path (expand-file-name "~/.emacs.d/lisp"))

(setq package-archives '(("gnu" . "http://elpa.gnu.org/packages/")
			 ("marmalade" . "https://marmalade-repo.org/packages/")
		         ("melpa" . "http://melpa.milkbox.net/packages/")))

;;----------------------------------------------------------------------------
;; Which functionality to enable (use t or nil for true and false)
;;----------------------------------------------------------------------------
(setq *macbook-pro-support-enabled* t)
(setq *is-a-mac* (eq system-type 'darwin))
(setq *is-carbon-emacs* (and *is-a-mac* (eq window-system 'mac)))
(setq *is-cocoa-emacs* (and *is-a-mac* (eq window-system 'ns)))
(setq *win32* (eq system-type 'windows-nt) )
(setq *cygwin* (eq system-type 'cygwin) )
(setq *linux* (or (eq system-type 'gnu/linux) (eq system-type 'linux)) )
(setq *unix* (or *linux* (eq system-type 'usg-unix-v) (eq system-type 'berkeley-unix)) )
(setq *linux-x* (and window-system *linux*) )
(setq *xemacs* (featurep 'xemacs) )
(setq *emacs23* (and (not *xemacs*) (or (>= emacs-major-version 23))) )
(setq *emacs24* (and (not *xemacs*) (or (>= emacs-major-version 24))) )
(setq *no-memory* (cond
		   (*is-a-mac*
		    (< (string-to-number (nth 1 (split-string (shell-command-to-string "sysctl hw.physmem")))) 4000000000))
		   (*linux* nil)
		   (t nil)
		                  ))


;;设置环境变量
(require 'init-path)

(require 'init-emacs-w3m)
;;(require 'init-yasnippets)
;;(require 'init-auto-complete)
(require 'init-idle-require)
(require 'init-anything)
(require 'init-xcode-document-viewer)

;; init-environment of the emacs
(require 'init-env) 

;;init helm-gtags
;;(require 'init-helm-gtags)


;; init-global-keys
(require 'init-global-keys)

;;lldb config
(require 'init-gud-lldb)

;;linear-undo config
(require 'init-linear-redo)

;;flymake config
(require 'init-flymake)

;;flycheck config
(require 'init-flycheck)

;;xcscope config
;;(require 'init-xcscope)

;;gtags config
;;(require 'init-gtags)


(require 'init-ggtags)

;;helm-etags-plus config
;;(require 'init-helm-etags-plus)

;;config org
(require 'init-org)


;;highlight symbol config
(require 'init-highlight-symbol)


(require 'init-iedit)
(setq idle-require-idle-delay 3)
(setq idle-require-symbols '(
			init-yasnippets
			init-auto-complete))
(idle-require-mode 1) ;; starts loading


;;默认路径
;;(setq ecb-source-path "~/work/ios/apple/hebtp/hebtp") 
(custom-set-variables
 ;; custom-set-variables was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 '(ecb-key-map
   (quote
    ("C-c ."
     (t "fh" ecb-history-filter)
     (t "fs" ecb-sources-filter)
     (t "fm" ecb-methods-filter)
     (t "fr" ecb-methods-filter-regexp)
     (t "ft" ecb-methods-filter-tagclass)
     (t "fc" ecb-methods-filter-current-type)
     (t "fp" ecb-methods-filter-protection)
     (t "fn" ecb-methods-filter-nofilter)
     (t "fl" ecb-methods-filter-delete-last)
     (t "ff" ecb-methods-filter-function)
     (t "p" ecb-nav-goto-previous)
     (t "n" ecb-nav-goto-next)
     (t "lc" ecb-change-layout)
     (t "lr" ecb-redraw-layout)
     (t "lw" ecb-toggle-ecb-windows)
     (t "lt" ecb-toggle-layout)
     (t "s" ecb-window-sync)
     (t "r" ecb-rebuild-methods-buffer)
     (t "a" ecb-toggle-auto-expand-tag-tree)
     (t "x" ecb-expand-methods-nodes)
     (t "h" ecb-show-help)
     (t "gl" ecb-goto-window-edit-last)
     (nil "C-c 1" ecb-goto-window-edit1)
     (nil "C-c 2" ecb-goto-window-edit2)
     (t "gc" ecb-goto-window-compilation)
     (nil "C-c d" ecb-goto-window-directories)
     (nil "C-c s" ecb-goto-window-sources)
     (nil "C-c m" ecb-goto-window-methods)
     (nil "C-c h" ecb-goto-window-history)
     (t "ga" ecb-goto-window-analyse)
     (t "gb" ecb-goto-window-speedbar)
     (t "md" ecb-maximize-window-directories)
     (t "ms" ecb-maximize-window-sources)
     (t "mm" ecb-maximize-window-methods)
     (t "mh" ecb-maximize-window-history)
     (t "ma" ecb-maximize-window-analyse)
     (t "mb" ecb-maximize-window-speedbar)
     (t "e" eshell)
     (t "o" ecb-toggle-scroll-other-window-scrolls-compile)
     (t "\\" ecb-toggle-compile-window)
     (t "/" ecb-toggle-compile-window-height)
     (t "," ecb-cycle-maximized-ecb-buffers)
     (t "." ecb-cycle-through-compilation-buffers))))
 '(ecb-layout-window-sizes
   (quote
    (("left8"
      (ecb-directories-buffer-name 0.2288135593220339 . 0.29411764705882354)
      (ecb-sources-buffer-name 0.2288135593220339 . 0.23529411764705882)
      (ecb-methods-buffer-name 0.2288135593220339 . 0.29411764705882354)
      (ecb-history-buffer-name 0.2288135593220339 . 0.16176470588235295)))))
 '(ecb-options-version "2.40")
 '(ecb-source-path (quote ("~/work/ios/apple/hebtp/hebtp")))
 '(send-mail-function (quote smtpmail-send-it)))
(custom-set-faces
 ;; custom-set-faces was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 )
