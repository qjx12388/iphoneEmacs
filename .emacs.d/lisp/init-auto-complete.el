;; auto-complete
(add-to-list 'load-path "~/.emacs.d/elpa/auto-complete-1.4")

;;auto-complete-clang-async config
(add-to-list 'load-path "~/.emacs.d/elpa/auto-complete-clang-async-20130526.814")

;;auto-complete-clang config
(add-to-list 'load-path "~/.emacs.d/elpa/auto-complete-clang-20140409.52")

(require 'auto-complete-config)

(require 'auto-complete-clang-async)



;;(setq ac-expand-on-auto-complete nil)
;;(setq ac-auto-start nil)
;;(setq ac-dwim nil) ; To get pop-ups with docs even if a word is uniquely completed
(ac-set-trigger-key "TAB") ; AFTER input prefix, press TAB key ASAPa

;; Use C-n/C-p to select candidate ONLY when completion menu is displayed
;; Below code is copied from official manual
(setq ac-use-menu-map t)
;; Default settings
(define-key ac-menu-map "\C-n" 'ac-next)
(define-key ac-menu-map "\C-p" 'ac-previous)
;; extra modes auto-complete must support
(dolist (mode '(magit-log-edit-mode log-edit-mode org-mode text-mode haml-mode
				    sass-mode yaml-mode csv-mode espresso-mode haskell-mode
				    html-mode web-mode sh-mode smarty-mode clojure-mode
				    lisp-mode textile-mode markdown-mode tuareg-mode
				    js2-mode css-mode less-css-mode objc-mode))
  (add-to-list 'ac-modes mode))

;; Exclude very large buffers from dabbrev
(defun sanityinc/dabbrev-friend-buffer (other-buffer)
  (< (buffer-size other-buffer) (* 1 1024 1024)))

(setq dabbrev-friend-buffer-function 'sanityinc/dabbrev-friend-buffer)





(add-to-list 'ac-dictionary-directories "~/.emacs.d/elpa/auto-complete-1.4/dict")

;; clang stuff
;; @see https://github.com/brianjcj/auto-complete-clang
(defun my-ac-cc-mode-setup ()
  (require 'auto-complete-clang)
  (when (and (not *cygwin*) (not *win32*))
					; I don't do C++ stuff with cygwin+clang
    (setq ac-sources (append '(ac-source-clang) ac-sources))
    )
  (setq clang-include-dir-str
	(cond
	          (*is-a-mac* "
/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS.sdk/usr/include
/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneOS.platform/usr/lib/clang/3.5/include
/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneSimulator.platform/Developer/SDKs/iPhoneSimulator.sdk/usr/include
/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneSimulator.platform/Developer/SDKs/iPhoneSimulator.sdk/usr/local/include
/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneSimulator.platform/Developer/SDKs/iPhoneSimulator7.1.sdk/usr/include
/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneSimulator.platform/Developer/SDKs/iPhoneSimulator7.1.sdk/usr/local/include

/Applications/Xcode.app/Contents/Developer/Platforms/MacOSX.platform/Developer/SDKs/MacOSX10.10.sdk/usr/include
/Applications/Xcode.app/Contents/Developer/Platforms/MacOSX.platform/Developer/SDKs/MacOSX10.9.sdk/usr/include

/Applications/Xcode.app/Contents/Developer/Toolchains/XcodeDefault.xctoolchain/usr/lib/swift/clang/3.5/include

/Applications/Xcode.app/Contents/Developer/usr/lib/llvm-gcc/4.2.1/include
/Library/Developer/CommandLineTools/usr/lib/llvm-gcc/4.2.1/include
/usr/include
/usr/local/Cellar/llvm/3.5.1/include
/usr/local/Cellar/llvm/3.5.1/lib/clang/3.5.1/include
/usr/local/include

/Applications/Xcode.app/Contents/Developer/Toolchains/XcodeDefault.xctoolchain/usr/include

/Applications/Xcode.app/Contents/Developer/Toolchains/XcodeDefault.xctoolchain/usr/lib/clang/6.0/include
/Applications/Xcode.app/Contents/SharedFrameworks/LLDB.framework/Versions/A/Resources/Clang/include
/Library/Developer/CommandLineTools/Library/PrivateFrameworks/LLDB.framework/Versions/A/Resources/Clang/include

")
		           (*cygwin* "
/usr/lib/gcc/i686-pc-cygwin/3.4.4/include/c++/i686-pc-cygwin
/usr/lib/gcc/i686-pc-cygwin/3.4.4/include/c++/backward
/usr/local/include
/usr/lib/gcc/i686-pc-cygwin/3.4.4/include
/usr/include
/usr/lib/gcc/i686-pc-cygwin/3.4.4/../../../../include/w32api
")
			            (*linux* "
/usr/include
/usr/lib/wx/include/gtk2-unicode-release-2.8
/usr/include/wx-2.8
/usr/include/gtk-2.0
/usr/lib/gtk-2.0/include
/usr/include/atk-1.0
/usr/include/cairo
/usr/include/gdk-pixbuf-2.0
/usr/include/pango-1.0
/usr/include/glib-2.0
/usr/lib/glib-2.0/include
/usr/include/pixman-1
/usr/include/freetype2
/usr/include/libpng14
")
				    )
	)
  (setq ac-clang-flags
	(mapcar (lambda (item) (concat "-I" item))
		(split-string clang-include-dir-str)))

;;  (cppcm-reload-all)
; fixed rinari's bug
  (remove-hook 'find-file-hook 'rinari-launch)

;;  (setq ac-clang-auto-save t)
    )





(setq-default ac-sources '(ac-source-yasnippet ac-source-abbrev ac-source-dictionary ac-source-words-in-same-mode-buffers))
(add-hook 'emacs-lisp-mode-hook 'ac-emacs-lisp-mode-setup)
(add-hook 'c-mode-common-hook 'ac-cc-mode-setup)
(add-hook 'ruby-mode-hook 'ac-ruby-mode-setup)
(add-hook 'css-mode-hook 'ac-css-mode-setup)
(add-hook 'auto-complete-mode-hook 'ac-common-setup)

(add-hook 'objc-mode-hook 'my-ac-cc-mode-setup)

(global-auto-complete-mode t)

;;(ac-config-default)
(provide 'init-auto-complete)
