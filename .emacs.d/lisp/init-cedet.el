;; cedet config
(add-to-list 'load-path "~/.emacs.d/elpa/cedet")
;;(add-to-list 'load-path "~/.emacs.d/elpa/cedet-1.0pre6/semantic")
(require 'cedet-devel-load)
;;(require 'cedet)
;;(load-file (concat user-emacs-directory "/cedet/cedet-devel-load.el"))

;;(load-file (concat user-emacs-directory "/elpa/cedet/lisp/cedet/cedet.el"))
;;load-file (concat user-emacs-directory "/elpa/cedet/contrib/cedet-contrib-load.el"))
;;(require 'cedet)
;;(require 'semantic-ia)
;;(require 'semantic)
;;(require 'semantic/ia)

;;(require 'semantic/bovine/gcc)

;;(semantic-load-enable-code-helpers)

;; ;;;;(add-to-list 'semantic-default-submodes 'global-semanticdb-minor-mode)
;; ;;;;(add-to-list 'semantic-default-submodes 'global-semantic-mru-bookmark-mode)
;; ;;(add-to-list 'semantic-default-submodes 'global-cedet-m3-minor-mode)
;; ;;;;(add-to-list 'semantic-default-submodes 'global-semantic-highlight-func-mode)
;; (add-to-list 'semantic-default-submodes 'global-semantic-stickyfunc-mode)
;; (add-to-list 'semantic-default-submodes 'global-semantic-decoration-mode)
;; (add-to-list 'semantic-default-submodes 'global-semantic-idle-local-symbol-highlight-mode)
;; (add-to-list 'semantic-default-submodes 'global-semantic-idle-scheduler-mode)
;; (add-to-list 'semantic-default-submodes 'global-semantic-idle-completions-mode)
;; (add-to-list 'semantic-default-submodes 'global-semantic-idle-summary-mode)

;;;(setq semantic-default-submodes '(global-semanticdb-minor-mode  ;; 保存分析内容
;;;				  global-semantic-idle-scheduler-mode  ;; Emacs空闲时自动分析buffer内容
;;;				  global-semantic-idle-summary-mode  ;; minibuffer显示函数原型
				  ;;global-semantic-idle-completions-mode  ;; 自动提示可以补全的内容
				  ;;global-semantic-decoration-mode  ;; 类/函数上方加一条线
;;;				  global-semantic-highlight-func-mode  ;; 高亮显示光标所在函数
				  ;;global-semantic-stickyfunc-mode  ;; 当前函数名显示在buffer上
;;;				  global-semantic-mru-bookmark-mode  ;; 书签记录
;;;				  global-semantic-idle-local-symbol-highlight-mode))  ;; 高亮光标处的同名变量

;;(semantic-mode 1)  ;; 启用semantic
;; 最近修改过的内容高亮
;;;(global-semantic-highlight-edits-mode (if window-system 1 -1))
;; 标识无法解析的内容
;;;(global-semantic-show-unmatched-syntax-mode 1)
;; Mode Line上显示当前解析状态
;;;(global-semantic-show-parser-state-mode 1)
;;System header files
;;(semantic-add-system-include "~/Applications/Xcode.app/Contents/Developer/Platforms/iPhoneOS.platform/Developer/SDKs/iPhoneOS8.1.sdk/System/Library/Frameworks" 'objc-mode)



;;(setq semanticdb-default-save-directory "~/.emacs.d/semanticdb")
;;(setq semanticdb-search-system-databases t)

;;(setq-mode-local objc-mode
;;		 semanticdb-find-default-throttle
;;		 '(project unloaded system recursive))

;;(semantic-mode 1)
(provide 'init-cedet)
