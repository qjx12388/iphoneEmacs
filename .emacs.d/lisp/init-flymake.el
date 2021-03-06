;;flymake config
(add-to-list 'load-path "~/.emacs.d/elpa/flymake-0.4.16")
(require 'flymake)

(defvar xcode:gccver "4.2.1")
(defvar xcode:sdkver "8.1")
(defvar xcode:sdkpath "/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneSimulator.platform/Developer")
(defvar xcode:sdk (concat xcode:sdkpath "/SDKs/iPhoneSimulator" xcode:sdkver ".sdk"))
;(defvar flymake-objc-compiler (concat xcode:sdkpath "/usr/bin/gcc-" xcode:gccver))
(defvar flymake-objc-compiler (concat xcode:sdkpath "/usr/bin/gcc"))
(defvar flymake-objc-compile-default-options (list "-Wall" "-Wextra" "-fsyntax-only" "-ObjC" "-std=c99" "-isysroot" xcode:sdk))
(defvar flymake-last-position nil)
;;(defvar flymake-objc-compile-options '("-I."))

(defvar flymake-objc-compile-options '("-I."))
  ;; "Compile option for objc check."
  ;;    :group 'flymake
  ;;    :type '(repeat (string)))

(defun flymake-objc-init ()
  (let* ((temp-file (flymake-init-create-temp-buffer-copy
                      'flymake-create-temp-inplace))
         (local-file (file-relative-name
                      temp-file
                      (file-name-directory buffer-file-name)
                      )

                     ))
    (list flymake-objc-compiler (append flymake-objc-compile-default-options flymake-objc-compile-options (list local-file)))))

(add-hook 'objc-mode-hook
         (lambda ()
           (push '("\\.m" flymake-objc-init) flymake-allowed-file-name-masks)
           (push '("\\.mm" flymake-objc-init) flymake-allowed-file-name-masks)
           (push '("\\.h" flymake-objc-init) flymake-allowed-file-name-masks)
(if (and (not (null buffer-file-name)) (file-writable-p buffer-file-name))
    (flymake-mode t))
    ))
                                (defun flymake-display-err-minibuffer ()
                                 "改行有 error 或 warinig 显示在 minibuffer"
                                    (interactive)
                                      (let* ((line-no (flymake-current-line-no))
                                               (line-err-info-list (nth 0 (flymake-find-err-info flymake-err-info line-no)))
                                                       (count (length line-err-info-list)))
                                          (while (> count 0)
                                                (when line-err-info-list
                                                (let* ((file (flymake-ler-file (nth (1- count) line-err-info-list)))
             (full-file (flymake-ler-full-file (nth (1- count) line-err-info-list)))
             (text (flymake-ler-text (nth (1- count) line-err-info-list)))
             (line (flymake-ler-line (nth (1- count) line-err-info-list))))
             (message "[%s] %s" line text)))
             (setq count (1- count)))))
                                (defadvice flymake-goto-next-error (after display-message activate compile)
                                 " 下一个错误"
                                    (flymake-display-err-minibuffer))
                                
                                (defadvice flymake-goto-prev-error (after display-message activate compile)
                                " 前一个错误"
                                   (flymake-display-err-minibuffer))
                                
                                (defadvice flymake-mode (before post-command-stuff activate compile)
                                "为了 将问题行自动显示到 minibuffer 中，添加 post command hook "
                                   (set (make-local-variable 'post-command-hook)
                                           (add-hook 'post-command-hook 'flymake-display-err-minibuffer)))
                                
                                ;; post-command-hook 与 anything.el 有冲突时使用
                                ;;(define-key global-map (kbd "C-c f") 'flymake-display-err-minibuffer)
                                (set-face-background 'flymake-errline "red")
                                (set-face-background 'flymake-warnline "yellow")


;;另外像下面给错误附上颜色，便于区分
(set-face-background 'flymake-errline "red")
(set-face-background 'flymake-warnline "yellow")

(provide 'init-flymake)
