panel.plugin("philipmarnef/display-uuid-field", {
	fields: {
		uuiddisplay: {
			computed: {
				uuid() {
					if (this.$panel.view.props.model.uuid)
						return this.$panel.view.props.model.uuid.substring(7);
					return "";
				},
			},
			template: `<k-info-field label="UUID" :text="uuid" theme="none" />`,
		},
	},
});
