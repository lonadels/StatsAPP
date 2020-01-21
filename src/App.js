import React, { useState, useEffect } from 'react';
import connect from '@vkontakte/vk-connect';
import { ConfigProvider, Root, View, Panel, ScreenSpinner } from '@vkontakte/vkui';
import '@vkontakte/vkui/dist/vkui.css';

const App = () => {
	const [fetchedUser, setUser] = useState(null);
	const [popout, setPopout] = useState(<ScreenSpinner size='large' />);

	useEffect(() => {
		connect.subscribe(({ detail: { type, data } }) => {
			if (type === 'VKWebAppUpdateConfig') {
				const schemeAttribute = document.createAttribute('scheme');
				schemeAttribute.value = data.scheme ? data.scheme : 'client_light';
				document.body.attributes.setNamedItem(schemeAttribute);
			}
		});
		async function fetchData() {
			const user = await connect.send('VKWebAppGetUserInfo');
			setUser(user);
			setPopout(null);
		}
		fetchData();
	}, []);

	return (
		<ConfigProvider>
			<Root popout={popout}>
				<View >
					<Panel>

					</Panel>
				</View>
			</Root>
		</ConfigProvider>
	);
}

export default App;

