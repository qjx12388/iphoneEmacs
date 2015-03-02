;;gtags config
(add-to-list 'load-path "~/.emacs.d/elpa/gtags-3.3")
(require 'gtags)

(setq gtags-suggested-key-mapping t)

(defun create-tags (dir-name)
  "Create tags file."
  (interactive "DDirectory: ")
  (eshell-command
   (format "find %s -type f -name \"*.[mh]\" -o -name \"*.mm\" | etags -" dir-name)))


;;Auto refresh of the tags file
(defadvice find-tag (around refresh-etags activate)
     "Rerun etags and reload tags if tag not found and redo find-tag.              
   If buffer is modified, ask about save before running etags."
     (let ((extension (file-name-extension (buffer-file-name))))
       (condition-case err
	   ad-do-it
	 (error (and (buffer-modified-p)
		     (not (ding))
		     (y-or-n-p "Buffer is modified, save it? ")
		     (save-buffer))
		(er-refresh-etags extension)
		ad-do-it))))
(defun er-refresh-etags (&optional extension)
  "Run etags on all peer files in current dir and reload them silently."
  (interactive)
  (shell-command (format "etags *.%s" (or extension "el")))
  (let ((tags-revert-without-query t))  ; don't query, revert silently
        (visit-tags-table default-directory nil)))


(require 'etags-update)
(etags-update-mode 1)

;;(gtags-mode 1)
(add-hook 'objc-mode-hook 'gtags-mode)
(provide 'init-gtags)
