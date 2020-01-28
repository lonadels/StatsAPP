import React, { Component } from 'react';

import connect from '@vkontakte/vk-connect';
import { ConfigProvider, Root, View, Panel, Button } from '@vkontakte/vkui';
import '@vkontakte/vkui/dist/vkui.css';

import { observer } from 'mobx-react'
import Counter from './Counter';

const App = observer(props => {
  const { count, increase, decrease } = Counter;

  return <ConfigProvider>
    <Root>
      <View>
        <Panel>
          <h1>Count: {count}</h1>
          <Button onClick={increase}>Inc</Button>
          <Button onClick={decrease}>Dec</Button>
        </Panel>
      </View>
    </Root>
  </ConfigProvider>
})

export default App;