;;Here’s my Emacs config for setting up pragma-marks
;;So whenever I am editing a source code file and I press Ctrl-x p here’s what I see in a separate buffer
;;(global-set-key "\C-xp" 'objc-headline)


;; --- Obj-C switch between header and source ---
(defun objc-in-header-file ()
  (let* ((filename (buffer-file-name))
	 (extension (car (last (split-string filename "\\.")))))
    (string= "h" extension)))

(defun objc-jump-to-extension (extension)
  (let* ((filename (buffer-file-name))
	 (file-components (append (butlast (split-string filename
							 "\\."))
				  (list extension))))
    (find-file (mapconcat 'identity file-components "."))))

;;; Assumes that Header and Source file are in same directory
(defun objc-jump-between-header-source ()
  (interactive)
  (if (objc-in-header-file)
      (objc-jump-to-extension "m")
    (objc-jump-to-extension "h")))

(defun objc-mode-customizations ()
  (define-key objc-mode-map (kbd "C-c t") 'objc-jump-between-header-source)
  (define-key objc-mode-map (kbd "C-x p") 'objc-headline)
  )

(add-hook 'objc-mode-hook 'objc-mode-customizations)



;;ecb-activate mode keys

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
      (ecb-directories-buffer-name 0.22033898305084745 . 0.29411764705882354)
      (ecb-sources-buffer-name 0.220338983050847¯45 . 0.23529411764705882)
      (ecb-methods-buffer-name 0.22033898305084745 . 0.29411764705882354)
      (ecb-history-buffer-name 0.22033898305084745 . 0.16176470588235295)))))
 '(ecb-options-version "2.40")
 '(send-mail-function (quote smtpmail-send-it)))
(custom-set-faces
 ;; custom-set-faces was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
  )


;;helm-gtags config
(setq helm-gtags-ignore-case t
      helm-gtags-auto-update t
      helm-gtags-use-input-at-cursor t
      helm-gtags-pulse-at-cursor t
      helm-gtags-suggested-key-mapping t)
(defun set-helm-gtags-keybindings ()
  (define-key helm-gtags-mode-map (kbd "C-c i") 'helm-gtags-tags-in-this-function)
  (define-key helm-gtags-mode-map (kbd "C-c r") 'helm-gtags-find-rtag)
  (define-key helm-gtags-mode-map (kbd "C-c a") 'helm-gtags-select)
  (define-key helm-gtags-mode-map (kbd "M-."    ) 'helm-gtags-dwim)
  (define-key helm-gtags-mode-map (kbd "M-,"    ) 'helm-gtags-pop-stack);;back to last place
  (define-key helm-gtags-mode-map (kbd "C-c p") 'helm-gtags-previous-history)
  (define-key helm-gtags-mode-map (kbd "C-c n") 'helm-gtags-next-history)
  (define-key helm-gtags-mode-map (kbd "C-c f") 'helm-gtags-find-files);;查找文件
  )
(add-hook 'helm-gtags-mode-hook 'set-helm-gtags-keybindings)


;;Xcode编译、执行，通过applescript
(defun xcode:simulatorbuild()
  (interactive)
;;  (do-applescript
;;   (format
;;    (concat
;;     "tell application \"Xcode\" to activate \r"
;;     "tell application \"System Events\" \r"
;;     "     tell process \"Xcode\" \r"
;;     "          key code 36 using {command down} \r"
;;     "    end tell \r"
;;     "end tell \r"
  ;;     ))))

  (message(shell-command-to-string (concat "cd "(xcode--project-root)";xcodebuild -sdk iphonesimulator8.1 -toolchain \"iPhone Developer\" -configuration Debug")))
  )

(defun xcode:simulatorrun()
  (interactive)
  (message
   (do-applescript
    (format
     (concat
      "tell application \"Terminal\" \r"
      "activate \r"
        "tell window 1 \r "
        "activate \r"
	"do script \"ios-sim launch "(xcode--project-root)"/build/Debug-iphonesimulator/hebtp.app --debug"
	" --devicetypeid 'com.apple.CoreSimulator.SimDeviceType.iPhone-4s, 8.1'"
	" \" \r"
	"end tell \r"
      "end tell \r"
      )
    )
    )
   )
 )

(defun xcode:devicerun()
  (interactive)
  (message(shell-command-to-string (concat "fruitstrap -d -b "(xcode--project-root) "/build/Release-iphoneos/hebtp.app")))
  )

(defun xcode:devicebuild()
  (interactive)
  (message(shell-command-to-string (concat "cd "(xcode--project-root)";xcodebuild -sdk iphoneos build"
					   ;;"-toolchain \"iPhone Developer\""
					   ;;"-configuration Debug"
					   )))
 )

(defvar *xcode-project-root* nil)

(defun xcode--project-root ()
  (or *xcode-project-root*
      (setq *xcode-project-root* (xcode--project-lookup))))

(defun xcode--project-lookup (&optional current-directory)
  (when (null current-directory) (setq current-directory default-directory))
  (cond ((xcode--project-for-directory (directory-files current-directory)) (expand-file-name current-directory))
	((equal (expand-file-name current-directory) "/") nil)
	(t (xcode--project-lookup (concat (file-name-as-directory current-directory) "..")))))

(defun xcode--project-for-directory (files)
  (let ((project-file nil))
    (dolist (file files project-file)
      (if (> (length file) 10)
	  (when (string-equal (substring file -10) ".xcodeproj") (setq project-file file))))))

(defun xcode--project-command (options)
  (concat "cd " (xcode--project-root) "; " options))

(defun xcode/build-compile ()
;;  (interactive)
  (compile (xcode--project-command (xcode--build-command))))

(defun xcode/build-list-sdks ()
  (interactive)
  (message (shell-command-to-string (xcode--project-command "xcodebuild -showsdks"))))

(defun xcode--build-command (&optional target configuration sdk)
  (let ((build-command "xcodebuild"))
    (if (not target)
	(setq build-command (concat build-command " -activetarget"))
      (setq build-command (concat build-command " -target " target)))
    (if (not configuration)
	(setq build-command (concat build-command " -activeconfiguration"))
      (setq build-command (concat build-command " -configuration " configuration)))
    (when sdk (setq build-command (concat build-command " -sdk " sdk)))
        build-command))

  
;;绑定快捷键，xcode－－－编译和执行
(add-hook 'objc-mode-hook
	  (lambda ()
	     (define-key objc-mode-map (kbd "s-b") 'xcode:simulatorbuild)
	     (define-key objc-mode-map (kbd "s-r") 'xcode:simulatorrun)
	            )) 


;;linear-undo config
(global-set-key "\C-xr" 'redo)

(provide 'init-global-keys)
