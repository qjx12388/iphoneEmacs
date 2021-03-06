;;config rainbow-mode
(add-to-list 'load-path "~/.emacs.d/elpa/rainbow-mode-0.11")

(require 'rainbow-mode)

(autoload 'rainbow-mode "rainbow-mode.el" "Minor mode for editing HTML colors" t)

(add-to-list 'auto-mode-alist '("\\.html$" . rainbow-mode))
(add-to-list 'auto-mode-alist '("\\.less$" . rainbow-mode))
(add-to-list 'auto-mode-alist '("\\.css$" . rainbow-mode))
(add-to-list 'auto-mode-alist '("\\.coffee$" . rainbow-mode))
(add-to-list 'auto-mode-alist '("\\.js$" . rainbow-mode))

(dolist (hook '(css-mode-hook
             html-mode-hook))
  (add-hook hook (lambda () (rainbow-mode t))))

(provide 'init-rainbow-mode)
