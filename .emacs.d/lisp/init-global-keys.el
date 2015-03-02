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
				  (list extension)))
;;        (find-file (mapconcat 'identity file-components "."))))
    (filepath (mapconcat 'identity file-components ".")))
  (if (file-readable-p filepath)
      (find-file filepath)
    nil
      )))


;;; Assumes that Header and Source file are in same directory
(defun objc-jump-between-header-source ()
  (interactive)
  (if (objc-in-header-file)
      (or
       (objc-jump-to-extension "m")
       (objc-jump-to-extension "mm")
       (objc-jump-to-extension "c")
       (objc-jump-to-extension "cc")
       (objc-jump-to-extension "cpp")
       )
    (objc-jump-to-extension "h")))

(defun objc-mode-customizations ()
  (define-key objc-mode-map (kbd "C-c t") 'objc-jump-between-header-source)
  (define-key objc-mode-map (kbd "C-x p") 'objc-headline)
  )

(add-hook 'objc-mode-hook 'objc-mode-customizations)


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
  (message(shell-command-to-string (concat "cd "(xcode--project-root)";xcodebuild -sdk iphonesimulator8.1 -toolchain \"iPhone Developer: Quanfeng Li (FQ4XV6GRU9)\" -configuration Debug")))
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

(defun xcode:simulatorClean()
  (interactive)
  (message
   (shell-command-to-string (concat "cd " (xcode--project-root)"; xcodebuild clean -sdk iphonesimulator8.1 -configuration Debug")))
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
	    ;;compile and debug ios config
	     (define-key objc-mode-map (kbd "s-b") 'xcode:simulatorbuild)
	     (define-key objc-mode-map (kbd "s-r") 'xcode:simulatorrun)
	     (define-key objc-mode-map (kbd "s-<backspace>") 'xcode:simulatorClean)
	     ;;comment config
	     (define-key objc-mode-map (kbd "M-;") 'comment-or-uncomment-region)
	     (define-key objc-mode-map (kbd "C-u M-;") 'comment-kill)
	     (define-key objc-mode-map (kbd "C-x ;") 'comment-set-column)
	     (define-key objc-mode-map (kbd "M-j") 'comment-indent-new-line)
	     (define-key global-map (kbd "C-c C-b") nil)
	     (define-key objc-mode-map (kbd "C-c C-b") 'comment-box)

	     ))



;;linear-undo config
(global-set-key "\C-xr" 'redo)

;;从后向前删除
(global-set-key (kbd "C-h") 'delete-backward-char)
(global-set-key (kbd "M-h") 'backward-kill-word)

;;标记整段
(global-set-key (kbd "M-p") 'mark-paragraph)


;;semantic config
;;control tab 智能提示
;;(global-set-key [(control tab)] 'semantic-ia-complete-symbol-menu)

;;new buffer and switch to it
(defun xah-new-empty-buffer()
  "Open a new empty buffer."
  (interactive)
  (let ((buf (generate-new-buffer "untitled")))
    (switch-to-buffer buf)
    (funcall (and initial-major-mode))
        (setq buffer-offer-save t)))
(global-set-key (kbd "M-n") 'xah-new-empty-buffer)

(provide 'init-global-keys)
