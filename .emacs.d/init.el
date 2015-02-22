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
(require 'init-yasnippets)
(require 'init-auto-complete)
(require 'init-anything)
(require 'init-xcode-document-viewer)

;; init-environment of the emacs
(require 'init-env) 

;;init helm-gtags
(require 'init-helm-gtags)


;; init-global-keys
(require 'init-global-keys)

;;gdb config
;;(require 'init-multi-gdb-ui)
;;(require 'init-multi-gud)

;;lldb config
(require 'init-gud-lldb)
