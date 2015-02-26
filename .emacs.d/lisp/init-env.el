;; config the gnu emacs's environment

;; drop the tool bar
(tool-bar-mode 0)
;; drop the menu bar
;;(menu-bar-mode 0)
;; drop the scroll bar
(scroll-bar-mode 0)

;; colortheme
(add-to-list 'load-path "~/.emacs.d/elpa/color-theme")
(add-to-list 'load-path "~/.emacs.d/elpa/color-theme-monokai-0.0.5")
(add-to-list 'load-path "~/.emacs.d/elpa/color-theme-molokai-0.1")

(require 'color-theme)
(require 'color-theme-monokai)
(require 'color-theme-molokai)
;;(color-theme-initialize)
(color-theme-molokai)
;; This line must be after color-theme-molokai! Don't know why.
(setq color-theme-illegal-faces "^\\(w3-\\|dropdown-\\|info-\\|linum\\|yas-\\|f\
ont-lock\\)")
;; (color-theme-select 'color-theme-xp)
;; (color-theme-xp)  

;;fullscreen
(toggle-frame-maximized)

;;display line num
(global-linum-mode 1)

;;时间使用24小时制
(setq display-time-24hr-format t)
(setq display-time-format "%Y-%02m-%02d %3a  %02H:%02M:%02S")

;;时间显示包括日期和具体时间
(setq display-time-day-and-date t)

;;时间栏旁边启用邮件设置
;;(setq display-time-use-mail-icon t)

;;时间的变化频率
(setq display-time-interval 1)

;;显示时间，格式如下
(display-time-mode 1)

;;在标题栏提示当前位置
;(setq frame-title-format
;      (list "[" '(:eval (projectile-project-name)) "]"
;	    "Welcome"
;	    '(buffer-file-name "%f" (dired-directory dired-directory "%b"))))


;;powerline
(require 'powerline)

;;(require 'init-dired+)

(require 'init-cedet)
(require 'init-ecb)
(require 'ecb-autoloads)
;;默认打开scratch buffer                                                        
(switch-to-buffer "*scratch*")                                                  
(delete-other-windows)                                                          
(setq inhibit-startup-screen t)                                                 
;;删除minibuffer的重复历史                                                       
(setq history-delete-duplicates t)                                              
;;自动更新buffer                                                                 
(setq auto-revert-mode 1)

(provide 'init-env)
