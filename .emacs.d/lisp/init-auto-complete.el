;; auto-complete
(add-to-list 'load-path "~/.emacs.d/elpa/auto-complete-1.4")
(require 'auto-complete-config)
(add-to-list 'ac-dictionary-directories "~/.emacs.d/elpa/auto-complete-1.4/dict")

(setq-default ac-sources '(ac-source-yasnippet ac-source-abbrev ac-source-dictionary ac-source-words-in-same-mode-buffers))
(add-hook 'emacs-lisp-mode-hook 'ac-emacs-lisp-mode-setup)
(add-hook 'c-mode-common-hook 'ac-cc-mode-setup)
(add-hook 'ruby-mode-hook 'ac-ruby-mode-setup)
(add-hook 'css-mode-hook 'ac-css-mode-setup)
(add-hook 'auto-complete-mode-hook 'ac-common-setup)
(global-auto-complete-mode t)
(add-to-list 'ac-modes 'objc-mode)

(provide 'init-auto-complete)
